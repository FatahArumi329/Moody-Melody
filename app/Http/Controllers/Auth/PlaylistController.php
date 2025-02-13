<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use Illuminate\Http\Request;

class PlaylistController extends Controller
{
    public function index()
    {
        $playlists = auth()->user()->playlists()->latest()->paginate(12);
        return view('playlists.index', compact('playlists'));
    }

    public function create()
    {
        return view('playlists.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'mood_id' => 'nullable|exists:moods,id'
        ]);

        $playlist = auth()->user()->playlists()->create($validated);

        return redirect()->route('playlists.show', $playlist)
            ->with('success', 'Playlist created successfully!');
    }

    public function show(Playlist $playlist)
    {
        $this->authorize('view', $playlist);
        return view('playlists.show', compact('playlist'));
    }

    public function addSong(Request $request, Playlist $playlist)
    {
        $this->authorize('update', $playlist);
        
        $validated = $request->validate([
            'song_id' => 'required|exists:songs,id'
        ]);

        $playlist->songs()->attach($validated['song_id'], [
            'order' => $playlist->songs()->count()
        ]);

        return response()->json(['success' => true]);
    }

    public function removeSong(Request $request, Playlist $playlist)
    {
        $this->authorize('update', $playlist);
        
        $validated = $request->validate([
            'song_id' => 'required|exists:songs,id'
        ]);

        $playlist->songs()->detach($validated['song_id']);

        return response()->json(['success' => true]);
    }
}
