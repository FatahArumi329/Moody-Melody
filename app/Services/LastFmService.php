<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class LastFmService
{
    protected $apiKey;
    protected $baseUrl = 'http://ws.audioscrobbler.com/2.0/';

    public function __construct()
    {
        $this->apiKey = config('services.lastfm.api_key');
    }

    public function getTrackInfo($artist, $track)
    {
        $cacheKey = "track_info:{$artist}:{$track}";
        
        return Cache::remember($cacheKey, 3600, function () use ($artist, $track) {
            $response = Http::get($this->baseUrl, [
                'method' => 'track.getInfo',
                'api_key' => $this->apiKey,
                'artist' => $artist,
                'track' => $track,
                'format' => 'json',
                'autocorrect' => 1
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['track'] ?? null;
            }

            return null;
        });
    }
}
