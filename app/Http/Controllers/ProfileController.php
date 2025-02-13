<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Update the user's profile photo.
     */
    public function updateProfilePhoto(Request $request)
    {
        try {
            $request->validate([
                'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            $user = auth()->user();

            if (!$request->hasFile('profile_photo')) {
                throw new \Exception('Tidak ada file yang diunggah.');
            }

            $file = $request->file('profile_photo');
            if (!$file->isValid()) {
                throw new \Exception('File tidak valid.');
            }

            // Hapus foto lama jika ada
            if ($user->profile_photo) {
                $oldPath = Storage::disk('public')->path($user->profile_photo);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            // Generate nama file yang unik
            $fileName = uniqid('profile_') . '_' . time() . '.' . $file->getClientOriginalExtension();
            
            // Pastikan direktori exists
            $uploadPath = 'profile-photos';
            if (!Storage::disk('public')->exists($uploadPath)) {
                Storage::disk('public')->makeDirectory($uploadPath);
            }
            
            // Simpan foto baru
            $path = $file->storeAs($uploadPath, $fileName, 'public');
            
            if (!$path) {
                throw new \Exception('Gagal menyimpan file.');
            }

            // Update database
            $user->profile_photo = $path;
            $user->save();

            return back()
                ->with('status', 'profile-photo-updated')
                ->with('message', 'Foto profil berhasil diperbarui!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation Error: ' . $e->getMessage());
            return back()
                ->withErrors($e->errors())
                ->withInput();

        } catch (\Exception $e) {
            \Log::error('Profile Photo Upload Error: ' . $e->getMessage());
            return back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
