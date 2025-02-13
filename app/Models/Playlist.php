<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'user_id'
    ];

    /**
     * Get the user that owns the playlist.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the songs for the playlist.
     */
    public function songs()
    {
        return $this->belongsToMany(Song::class, 'playlist_songs')
                    ->withTimestamps();
    }
}
