<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use App\Models\PlaylistSong;
use App\Models\Song;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PlaylistController extends Controller
{
    public function index()
    {
        $playlists = Auth::user()->playlists;
        return view('playlists.index', compact('playlists'));
    }

    public function create()
    {
        return view('playlists.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Auth::user()->playlists()->create($request->all());

        return redirect()->route('dashboard')->with('success', 'Playlist created successfully.');
    }

    public function show(Playlist $playlist)
    {
        // Memastikan user hanya bisa melihat playlist miliknya
        if ($playlist->user_id !== auth()->id()) {
            abort(403);
        }

        // Mengambil lagu-lagu yang ada di playlist
        $songs = $playlist->songs;
        
        return view('playlists.show', compact('playlist', 'songs'));
    }

    public function edit(Playlist $playlist)
    {
        // Memastikan user hanya bisa mengedit playlist miliknya
        if ($playlist->user_id !== auth()->id()) {
            abort(403);
        }

        // Mengambil lagu-lagu yang ada di playlist
        $songs = $playlist->songs;
        
        return view('playlists.edit', compact('playlist', 'songs'));
    }

    public function update(Request $request, Playlist $playlist)
    {
        // Memastikan user hanya bisa mengupdate playlist miliknya
        if ($playlist->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $playlist->update($validated);

        return redirect()->route('playlists.show', $playlist)->with('success', 'Playlist updated successfully');
    }

    public function destroy(Playlist $playlist)
    {
        if ($playlist->user_id !== Auth::id()) {
            abort(403);
        }
        
        $playlist->delete();

        return redirect()->route('dashboard')->with('success', 'Playlist deleted successfully.');
    }

    public function addSong(Request $request)
    {
        $request->validate([
            'playlist_id' => 'required|exists:playlists,id',
            'title' => 'required|string',
            'artist' => 'required|string',
            'url' => 'required|string'
        ]);

        $playlist = Playlist::findOrFail($request->playlist_id);
        
        // Check if user owns the playlist
        if ($playlist->user_id !== Auth::id()) {
            return back()->with('error', 'You do not have permission to modify this playlist.');
        }

        // Find or create the song
        $song = Song::firstOrCreate([
            'title' => $request->title,
            'artist' => $request->artist,
            'song_url' => $request->url
        ]);

        // Check if song already exists in playlist
        if ($playlist->songs()->where('song_id', $song->id)->exists()) {
            return back()->with('error', 'This song is already in the playlist.');
        }

        // Add song to playlist
        $playlist->songs()->attach($song->id);

        return back()->with('success', 'Song added to playlist successfully.');
    }

    public function removeSong(Playlist $playlist, Song $song)
    {
        // Memastikan user hanya bisa menghapus lagu dari playlist miliknya
        if ($playlist->user_id !== auth()->id()) {
            abort(403);
        }

        $playlist->songs()->detach($song->id);
        
        return redirect()->back()->with('success', 'Song removed from playlist successfully');
    }

    public function addSongNew(Request $request)
    {
        $request->validate([
            'playlist_id' => 'required|exists:playlists,id',
            'title' => 'required|string|max:255',
            'artist' => 'required|string|max:255',
            'url' => 'required|url|max:1000',
        ]);

        $playlist = Playlist::findOrFail($request->playlist_id);

        // Verify ownership
        if ($playlist->user_id !== Auth::id()) {
            abort(403);
        }

        // Create or find the song
        $song = Song::firstOrCreate(
            [
                'title' => $request->title,
                'artist' => $request->artist,
                'song_url' => $request->url,
            ]
        );

        // Attach song to playlist if not already attached
        if (!$playlist->songs()->where('songs.id', $song->id)->exists()) {
            $playlist->songs()->attach($song->id);
            return back()->with('success', 'Song added to playlist successfully.');
        }

        return back()->with('error', 'Song already exists in the playlist.');
    }

    public function removeSongNew(Request $request, Playlist $playlist, Song $song)
    {
        if ($playlist->user_id !== Auth::id()) {
            abort(403);
        }

        $playlist->songs()->detach($song->id);
        return back()->with('success', 'Song removed from playlist successfully.');
    }
}
