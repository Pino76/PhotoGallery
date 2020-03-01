<?php

namespace App\Models;

use App\Models\Album;
use App\Models\AlbumCategory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    #Un utente ha tanti album
    public function albums(){
        return $this->hasMany(Album::class);
    }

    public function  getFullNameAttribute(){
        return $this->name;
    }

    public function albumCategories(){
        return $this->hasMany(AlbumCategory::class);
    }

    public function isAdmin(){
        return $this->role == 'admin';
    }
}
