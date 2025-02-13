<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'profile_photo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function playlists()
    {
        return $this->hasMany(Playlist::class);
    }

    public function getProfilePhotoUrlAttribute()
    {
        if ($this->profile_photo) {
            $path = 'storage/' . $this->profile_photo;
            if (file_exists(public_path($path))) {
                return asset($path);
            }
        }
        
        // Generate avatar dengan warna yang sesuai tema aplikasi
        $name = urlencode($this->name);
        $background = urlencode('#1d3c45'); // Warna background sesuai tema
        $color = urlencode('#fff1e1'); // Warna text sesuai tema
        return "https://ui-avatars.com/api/?name={$name}&background={$background}&color={$color}&size=200&bold=true";
    }

    public function deleteProfilePhoto()
    {
        if ($this->profile_photo && Storage::disk('public')->exists($this->profile_photo)) {
            Storage::disk('public')->delete($this->profile_photo);
        }
        
        $this->profile_photo = null;
        $this->save();
    }
}
