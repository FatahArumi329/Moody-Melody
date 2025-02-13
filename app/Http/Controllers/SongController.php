<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Song;
use App\Services\LastFmService;

class SongController extends Controller
{
    protected $lastFmService;

    public function __construct(LastFmService $lastFmService)
    {
        $this->lastFmService = $lastFmService;
    }

    public function index(Request $request)
    {
        $query = $request->input('search');
        
        if ($query) {
            $songs = Song::where('title', 'like', '%' . $query . '%')
                        ->orWhere('artist', 'like', '%' . $query . '%')
                        ->get();
        } else {
            $songs = Song::all();
        }
        
        return view('moods.songs', compact('songs'));
    }

    public function search(Request $request)
    {
        $query = $request->input('search');
        
        if (empty($query)) {
            return response()->json([]);
        }

        $songs = Song::where('title', 'like', '%' . $query . '%')
                    ->orWhere('artist', 'like', '%' . $query . '%')
                    ->get();

        return response()->json($songs);
    }

    public function details($title, $artist)
    {
        $song = Song::where('title', urldecode($title))
                   ->where('artist', urldecode($artist))
                   ->first();

        if (!$song) {
            return redirect()->back()->with('error', 'Song not found.');
        }

        $trackInfo = $this->lastFmService->getTrackInfo($song->artist, $song->title);

        return view('songs.details', [
            'song' => $song,
            'trackInfo' => $trackInfo
        ]);
    }
}