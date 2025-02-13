<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mood extends Model
{
    protected $fillable = ['name', 'description'];

    public function songs()
    {
        return $this->hasMany(Song::class);
    }

    public function playlists()
    {
        return $this->hasMany(Playlist::class);
    }
}
