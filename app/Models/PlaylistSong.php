<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlaylistSong extends Model
{
    use HasFactory;

    protected $table = 'playlist_song';

    protected $fillable = [
        'playlist_id',
        'title',
        'artist',
        'song_url',
        'order'
    ];

    /**
     * Get the playlist that owns the song.
     */
    public function playlist()
    {
        return $this->belongsTo(Playlist::class);
    }
}
