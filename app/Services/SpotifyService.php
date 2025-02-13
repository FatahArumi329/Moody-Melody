<?php

namespace App\Services;

use SpotifyWebAPI\SpotifyWebAPI;

class SpotifyService
{
    protected $spotify;

    public function __construct(SpotifyWebAPI $spotify)
    {
        $this->spotify = $spotify;
        $this->setAccessToken();
    }

    protected function setAccessToken()
    {
        if (session()->has('spotify_access_token')) {
            try {
                $this->spotify->setAccessToken(session('spotify_access_token'));
                return true;
            } catch (\Exception $e) {
                \Log::error('Error setting Spotify access token: ' . $e->getMessage());
                return false;
            }
        }
        return false;
    }

    public function isConnected()
    {
        if (!session()->has('spotify_access_token')) {
            return false;
        }

        try {
            // Test the connection by getting the current user's profile
            $this->spotify->me();
            return true;
        } catch (\Exception $e) {
            \Log::error('Spotify connection test failed: ' . $e->getMessage());
            return false;
        }
    }

    public function getRecommendationsByMood($mood)
    {
        if (!$this->isConnected()) {
            throw new \Exception('Not connected to Spotify');
        }

        $moodAttributes = $this->getMoodAttributes($mood);
        
        try {
            // Get some seed tracks based on mood
            $searchResults = $this->spotify->search($mood, 'track', ['limit' => 5]);
            $seedTracks = [];
            if (isset($searchResults->tracks->items)) {
                foreach ($searchResults->tracks->items as $track) {
                    $seedTracks[] = $track->id;
                }
            }

            // Get recommendations using both seed tracks and audio features
            $params = [
                'limit' => 10,
                'target_valence' => $moodAttributes['valence'],
                'target_energy' => $moodAttributes['energy'],
                'target_danceability' => $moodAttributes['danceability']
            ];

            if (!empty($seedTracks)) {
                $params['seed_tracks'] = array_slice($seedTracks, 0, 5);
            }

            \Log::info('Getting Spotify recommendations with params:', $params);
            return $this->spotify->getRecommendations($params);
        } catch (\Exception $e) {
            \Log::error('Spotify API Error: ' . $e->getMessage());
            throw $e;
        }
    }

    protected function getMoodAttributes($mood)
    {
        $moodMap = [
            'happy' => [
                'valence' => 0.8,    // High positivity
                'energy' => 0.7,     // High energy
                'danceability' => 0.7 // High danceability
            ],
            'relaxed' => [
                'valence' => 0.5,    // Moderate positivity
                'energy' => 0.3,     // Low energy
                'danceability' => 0.4 // Moderate-low danceability
            ],
            'energetic' => [
                'valence' => 0.6,    // Moderate-high positivity
                'energy' => 0.9,     // Very high energy
                'danceability' => 0.8 // High danceability
            ],
            'romantic' => [
                'valence' => 0.6,    // Moderate-high positivity
                'energy' => 0.4,     // Moderate-low energy
                'danceability' => 0.5 // Moderate danceability
            ],
            'focused' => [
                'valence' => 0.5,    // Moderate positivity
                'energy' => 0.4,     // Moderate-low energy
                'danceability' => 0.3 // Low danceability
            ],
            'melancholic' => [
                'valence' => 0.3,    // Low positivity
                'energy' => 0.4,     // Moderate-low energy
                'danceability' => 0.4 // Moderate-low danceability
            ],
            'party' => [
                'valence' => 0.7,    // High positivity
                'energy' => 0.8,     // High energy
                'danceability' => 0.9 // Very high danceability
            ]
        ];

        return $moodMap[strtolower($mood)] ?? [
            'valence' => 0.5,
            'energy' => 0.5,
            'danceability' => 0.5
        ];
    }

    public function searchTracks($query, $limit = 10)
    {
        return $this->spotify->search($query, 'track', [
            'limit' => $limit
        ]);
    }

    public function getTrack($trackId)
    {
        return $this->spotify->getTrack($trackId);
    }

    public function createPlaylist($userId, $name, $description = '', $public = true)
    {
        return $this->spotify->createUserPlaylist($userId, [
            'name' => $name,
            'description' => $description,
            'public' => $public
        ]);
    }

    public function addTracksToPlaylist($playlistId, $trackIds)
    {
        return $this->spotify->addPlaylistTracks($playlistId, $trackIds);
    }
}
