<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Playlist;

class Song extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'artist',
        'song_url'
    ];

    // Model ini tidak perlu disimpan ke database
    public $exists = false;
    protected $keyType = 'string';

    public function playlists()
    {
        return $this->belongsToMany(Playlist::class, 'playlist_songs')
                    ->withTimestamps();
    }
}
