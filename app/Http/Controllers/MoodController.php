<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MoodController extends Controller
{
    public function index()
    {
        return view('moods.index');
    }

    public function showCustomForm()
    {
        return view('moods.custom');
    }

    public function showSongsByMood($mood)
    {
        $limit = request('limit', 10); // Default to 10 if not specified
        $songs = $this->getSongsByMood($mood, $limit);
        return view('moods.songs', ['songs' => $songs, 'mood' => ucfirst($mood)]);
    }

    public function showHappyMood()
    {
        $limit = request('limit', 10);
        $songs = $this->getSongsByMood('happy', $limit);
        $playlists = auth()->user()->playlists;
        return view('moods.songs', ['songs' => $songs, 'mood' => 'Happy', 'playlists' => $playlists]);
    }

    public function showSadMood()
    {
        $limit = request('limit', 10);
        $songs = $this->getSongsByMood('sad', $limit);
        $playlists = auth()->user()->playlists;
        return view('moods.songs', ['songs' => $songs, 'mood' => 'Sad', 'playlists' => $playlists]);
    }

    public function showEnergeticMood()
    {
        $limit = request('limit', 10);
        $songs = $this->getSongsByMood('energetic', $limit);
        $playlists = auth()->user()->playlists;
        return view('moods.songs', ['songs' => $songs, 'mood' => 'Energetic', 'playlists' => $playlists]);
    }

    public function showCalmMood()
    {
        $limit = request('limit', 10);
        $songs = $this->getSongsByMood('calm', $limit);
        $playlists = auth()->user()->playlists;
        return view('moods.songs', ['songs' => $songs, 'mood' => 'Calm', 'playlists' => $playlists]);
    }

    public function showRomanticMood()
    {
        $limit = request('limit', 10);
        $songs = $this->getSongsByMood('romantic', $limit);
        $playlists = auth()->user()->playlists;
        return view('moods.songs', ['songs' => $songs, 'mood' => 'Romantic', 'playlists' => $playlists]);
    }

    public function showFocusedMood()
    {
        $limit = request('limit', 10);
        $songs = $this->getSongsByMood('focused', $limit);
        $playlists = auth()->user()->playlists;
        return view('moods.songs', ['songs' => $songs, 'mood' => 'Focused', 'playlists' => $playlists]);
    }

    public function showAnxiousMood()
    {
        $limit = request('limit', 10);
        $songs = $this->getSongsByMood('anxious', $limit);
        $playlists = auth()->user()->playlists;
        return view('moods.songs', ['songs' => $songs, 'mood' => 'Anxious', 'playlists' => $playlists]);
    }

    public function showSurprisedMood()
    {
        $limit = request('limit', 10);
        $songs = $this->getSongsByMood('surprised', $limit);
        $playlists = auth()->user()->playlists;
        return view('moods.songs', ['songs' => $songs, 'mood' => 'Surprised', 'playlists' => $playlists]);
    }

    public function showCustomMood()
    {
        $playlists = auth()->user()->playlists;
        return view('moods.custom', ['playlists' => $playlists]);
    }

    private function getSongsByMood($mood)
    {
        $apiKey = config('services.lastfm.api_key');
        
        $moodGenres = [
            'happy' => ['pop', 'dance', 'disco'],
            'sad' => ['blues', 'acoustic', 'indie'],
            'energetic' => ['rock', 'electronic', 'dance'],
            'relaxed' => ['ambient', 'classical', 'jazz'],
            'focused' => ['classical', 'instrumental', 'piano'],
            'romantic' => ['love', 'romance', 'ballad'],
            'anxious' => ['alternative', 'rock', 'metal'],
            'surprised' => ['experimental', 'electronic', 'pop'],
            'calm' => ['ambient', 'chillout', 'meditation']
        ];

        $genres = $moodGenres[strtolower($mood)] ?? ['pop'];
        $allSongs = collect();

        try {
            // Mengambil lagu dari setiap genre untuk mood tersebut
            foreach ($genres as $genre) {
                \Log::info("Fetching songs for mood: {$mood}, genre: {$genre}");
                
                $response = Http::get("http://ws.audioscrobbler.com/2.0/", [
                    'method' => 'tag.gettoptracks',
                    'tag' => $genre,
                    'api_key' => $apiKey,
                    'format' => 'json',
                    'limit' => 30  // Mengambil 30 lagu per genre
                ]);

                if ($response->successful()) {
                    $tracks = $response->json()['tracks']['track'] ?? [];
                    \Log::info("Retrieved " . count($tracks) . " tracks from Last.fm API for genre: {$genre}");
                    
                    // Menambahkan lagu-lagu dari genre ini ke koleksi
                    $allSongs = $allSongs->concat(
                        collect($tracks)->map(function ($song) {
                            return [
                                'title' => $song['name'],
                                'artist' => $song['artist']['name'],
                                'url' => $song['url']
                            ];
                        })
                    );
                } else {
                    \Log::error("Last.fm API error for genre {$genre}: " . $response->body());
                }
            }

            // Menghapus duplikat berdasarkan kombinasi judul dan artis
            $uniqueSongs = $allSongs->unique(function ($song) {
                return $song['title'] . ' - ' . $song['artist'];
            });

            \Log::info("Total unique songs collected: " . $uniqueSongs->count());
            
            // Mengacak urutan lagu dan mengambil 50 lagu
            return $uniqueSongs->shuffle()->take(50)->values();

        } catch (\Exception $e) {
            \Log::error("Error fetching songs: " . $e->getMessage());
            return collect([]);
        }
    }

    private function getFallbackSongs($mood)
    {
        $fallbackSongs = [
            'happy' => [
                ['title' => 'Happy', 'artist' => 'Pharrell Williams', 'url' => 'https://www.last.fm/music/Pharrell+Williams/_/Happy'],
                ['title' => "Don't Stop Believin'", 'artist' => 'Journey', 'url' => 'https://www.last.fm/music/Journey/_/Don%27t+Stop+Believin%27'],
                ['title' => 'Walking on Sunshine', 'artist' => 'Katrina & The Waves', 'url' => 'https://www.last.fm/music/Katrina+&+The+Waves/_/Walking+on+Sunshine'],
                ['title' => 'Uptown Funk', 'artist' => 'Mark Ronson ft. Bruno Mars', 'url' => 'https://www.last.fm/music/Mark+Ronson/_/Uptown+Funk'],
                ['title' => "Can't Stop the Feeling!", 'artist' => 'Justin Timberlake', 'url' => 'https://www.last.fm/music/Justin+Timberlake/_/Can%27t+Stop+the+Feeling%21']
            ],
            'sad' => [
                ['title' => 'Someone Like You', 'artist' => 'Adele', 'url' => 'https://www.last.fm/music/Adele/_/Someone+Like+You'],
                ['title' => 'All By Myself', 'artist' => 'Celine Dion', 'url' => 'https://www.last.fm/music/Celine+Dion/_/All+By+Myself'],
                ['title' => 'Yesterday', 'artist' => 'The Beatles', 'url' => 'https://www.last.fm/music/The+Beatles/_/Yesterday'],
                ['title' => 'Hurt', 'artist' => 'Johnny Cash', 'url' => 'https://www.last.fm/music/Johnny+Cash/_/Hurt'],
                ['title' => 'Nothing Compares 2 U', 'artist' => "Sinéad O'Connor", 'url' => 'https://www.last.fm/music/Sin%C3%A9ad+O%27Connor/_/Nothing+Compares+2+U']
            ],
            'energetic' => [
                ['title' => 'Eye of the Tiger', 'artist' => 'Survivor', 'url' => 'https://www.last.fm/music/Survivor/_/Eye+of+the+Tiger'],
                ['title' => 'Stronger', 'artist' => 'Kanye West', 'url' => 'https://www.last.fm/music/Kanye+West/_/Stronger'],
                ['title' => 'Thunderstruck', 'artist' => 'AC/DC', 'url' => 'https://www.last.fm/music/AC%2FDC/_/Thunderstruck'],
                ['title' => 'Levels', 'artist' => 'Avicii', 'url' => 'https://www.last.fm/music/Avicii/_/Levels'],
                ['title' => "Can't Hold Us", 'artist' => 'Macklemore & Ryan Lewis', 'url' => 'https://www.last.fm/music/Macklemore+&+Ryan+Lewis/_/Can%27t+Hold+Us']
            ],
            'relaxed' => [
                ['title' => 'Weightless', 'artist' => 'Marconi Union', 'url' => 'https://www.last.fm/music/Marconi+Union/_/Weightless'],
                ['title' => 'Claire de Lune', 'artist' => 'Claude Debussy', 'url' => 'https://www.last.fm/music/Claude+Debussy/_/Claire+de+Lune'],
                ['title' => 'River Flows in You', 'artist' => 'Yiruma', 'url' => 'https://www.last.fm/music/Yiruma/_/River+Flows+in+You'],
                ['title' => 'The Sea', 'artist' => 'Brian Eno', 'url' => 'https://www.last.fm/music/Brian+Eno/_/The+Sea'],
                ['title' => 'Gymnopédie No.1', 'artist' => 'Erik Satie', 'url' => 'https://www.last.fm/music/Erik+Satie/_/Gymnop%C3%A9die+No.1']
            ],
            'focused' => [
                ['title' => 'Time', 'artist' => 'Hans Zimmer', 'url' => 'https://www.last.fm/music/Hans+Zimmer/_/Time'],
                ['title' => 'Experience', 'artist' => 'Ludovico Einaudi', 'url' => 'https://www.last.fm/music/Ludovico+Einaudi/_/Experience'],
                ['title' => 'The Scientist', 'artist' => 'Coldplay', 'url' => 'https://www.last.fm/music/Coldplay/_/The+Scientist'],
                ['title' => 'Divenire', 'artist' => 'Ludovico Einaudi', 'url' => 'https://www.last.fm/music/Ludovico+Einaudi/_/Divenire'],
                ['title' => "Comptine d'un autre été, l'après-midi", 'artist' => 'Yann Tiersen', 'url' => 'https://www.last.fm/music/Yann+Tiersen/_/Comptine+d%27un+autre+%C3%A9t%C3%A9%2C+l%27apr%C3%A8s-midi']
            ]
        ];

        return collect($fallbackSongs[strtolower($mood)] ?? $fallbackSongs['happy']);
    }
}
