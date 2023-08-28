<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use DateTime;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'profile_image',
        'email',
        'contact_number',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'user_id');
    }

    protected function setPasswordAttribute($value): void
    {
        $this->attributes['password'] = bcrypt($value);
    }

    protected function getProfileImageUrlAttribute(): string
    {
        return (strpos($this->profile_image, '://')) ? $this->profile_image : env('APP_URL')."/storage/$this->profile_image";
    }

    protected function getDateJoinedAttribute(): string
    {
        return date('d M Y', strtotime($this->created_at));
    }
}
