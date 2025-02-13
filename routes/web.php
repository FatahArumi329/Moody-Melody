<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MoodController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

// Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/home', function () {
        return redirect()->route('dashboard');
    })->name('home');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/photo', [ProfileController::class, 'updateProfilePhoto'])->name('profile.photo.update');

    // Mood routes
    Route::middleware('auth')->group(function () {
        Route::get('/moods', [MoodController::class, 'index'])->name('moods.index');
        Route::get('/moods/custom', [MoodController::class, 'showCustomForm'])->name('moods.custom');
        Route::get('/moods/{mood}/songs', [MoodController::class, 'showSongsByMood'])->name('moods.songs');
        Route::get('/moods/happy', [MoodController::class, 'showHappyMood'])->name('moods.happy');
        Route::get('/moods/sad', [MoodController::class, 'showSadMood'])->name('moods.sad');
        Route::get('/moods/angry', [MoodController::class, 'showAngryMood'])->name('moods.angry');
        Route::get('/moods/fearful', [MoodController::class, 'showFearfulMood'])->name('moods.fearful');
        Route::get('/moods/surprised', [MoodController::class, 'showSurprisedMood'])->name('moods.surprised');
    });

    // Playlist routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/playlists', [PlaylistController::class, 'index'])->name('playlists.index');
        Route::get('/playlists/create', [PlaylistController::class, 'create'])->name('playlists.create');
        Route::post('/playlists', [PlaylistController::class, 'store'])->name('playlists.store');
        Route::get('/playlists/{playlist}', [PlaylistController::class, 'show'])->name('playlists.show');
        Route::get('/playlists/{playlist}/edit', [PlaylistController::class, 'edit'])->name('playlists.edit');
        Route::put('/playlists/{playlist}', [PlaylistController::class, 'update'])->name('playlists.update');
        Route::delete('/playlists/{playlist}', [PlaylistController::class, 'destroy'])->name('playlists.destroy');
        Route::post('/playlists/add-song', [PlaylistController::class, 'addSongNew'])->name('playlists.add-song');
        Route::delete('/playlists/{playlist}/songs/{song}', [PlaylistController::class, 'removeSong'])->name('playlists.removeSong');
    });
});

// Route untuk mendeteksi mood
Route::post('/moods/detect', [MoodController::class, 'detect'])->name('moods.detect');

// Route untuk SongController
Route::get('/songs', [SongController::class, 'index'])->name('songs.index');
Route::get('/songs/search', [SongController::class, 'search'])->name('songs.search');
Route::get('/songs/details/{title}/{artist}', [SongController::class, 'details'])->name('songs.details');

require __DIR__.'/auth.php';
