<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use App\Models\Song;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $playlists = Playlist::where('user_id', $user->id)->get();
        
        // Get songs from Last.fm API
        $songs = $this->getAllSongs();

        return view('dashboard', compact('playlists', 'songs'));
    }

    private function getAllSongs()
    {
        $genres = [
            'pop', 'rock', 'jazz', 'classical', 'electronic', 
            'hip-hop', 'indie', 'metal', 'blues', 'country'
        ];
        $allSongs = collect();

        $apiKey = config('services.lastfm.key', '4f2af4d5c5884c3b1e7c6b8b7a7e6d5c');

        foreach ($genres as $genre) {
            try {
                // Coba ambil lagu populer berdasarkan genre
                $response = Http::get('https://ws.audioscrobbler.com/2.0/', [
                    'method' => 'tag.gettoptracks',
                    'tag' => $genre,
                    'api_key' => $apiKey,
                    'format' => 'json',
                    'limit' => 20
                ]);

                if ($response->successful() && isset($response['tracks']['track'])) {
                    $tracks = collect($response['tracks']['track'])->map(function ($track) use ($genre) {
                        return new Song([
                            'title' => $track['name'] ?? 'Unknown Title',
                            'artist' => is_array($track['artist']) ? ($track['artist']['name'] ?? 'Unknown Artist') : $track['artist'],
                            'url' => $track['url'] ?? '#',
                            'genre' => $genre
                        ]);
                    });

                    $allSongs = $allSongs->concat($tracks);
                }

                // Tambahkan juga lagu terbaru
                $response = Http::get('https://ws.audioscrobbler.com/2.0/', [
                    'method' => 'tag.gettracks',
                    'tag' => $genre,
                    'api_key' => $apiKey,
                    'format' => 'json',
                    'limit' => 10
                ]);

                if ($response->successful() && isset($response['tracks']['track'])) {
                    $tracks = collect($response['tracks']['track'])->map(function ($track) use ($genre) {
                        return new Song([
                            'title' => $track['name'] ?? 'Unknown Title',
                            'artist' => is_array($track['artist']) ? ($track['artist']['name'] ?? 'Unknown Artist') : $track['artist'],
                            'url' => $track['url'] ?? '#',
                            'genre' => $genre
                        ]);
                    });

                    $allSongs = $allSongs->concat($tracks);
                }
            } catch (\Exception $e) {
                \Log::error("Error fetching songs for genre {$genre}: " . $e->getMessage());
                continue;
            }
        }

        // Jika tidak ada lagu dari API, gunakan lagu fallback
        if ($allSongs->isEmpty()) {
            $allSongs = collect($this->getFallbackSongs());
        }

        // Hilangkan duplikat dan acak urutan lagu
        return $allSongs->unique(function ($song) {
            return $song->title . $song->artist;
        })->shuffle();
    }

    private function getFallbackSongs()
    {
        return [
            new Song([
                'title' => 'Happy',
                'artist' => 'Pharrell Williams',
                'url' => 'https://www.last.fm/music/Pharrell+Williams/_/Happy',
                'genre' => 'Pop'
            ]),
            new Song([
                'title' => 'Bohemian Rhapsody',
                'artist' => 'Queen',
                'url' => 'https://www.last.fm/music/Queen/_/Bohemian+Rhapsody',
                'genre' => 'Rock'
            ]),
            new Song([
                'title' => 'Take Five',
                'artist' => 'Dave Brubeck',
                'url' => 'https://www.last.fm/music/Dave+Brubeck/_/Take+Five',
                'genre' => 'Jazz'
            ]),
            new Song([
                'title' => 'Für Elise',
                'artist' => 'Ludwig van Beethoven',
                'url' => 'https://www.last.fm/music/Ludwig+van+Beethoven/_/F%C3%BCr+Elise',
                'genre' => 'Classical'
            ]),
            new Song([
                'title' => 'Strobe',
                'artist' => 'deadmau5',
                'url' => 'https://www.last.fm/music/deadmau5/_/Strobe',
                'genre' => 'Electronic'
            ])
        ];
    }
}
