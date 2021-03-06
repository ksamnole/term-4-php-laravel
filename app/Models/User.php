<?php

namespace App\Models;

use App\Http\Controllers\PostController;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getUsername()
    {
        if ($this->username) {
            return "{$this->username}";
        }
        return null;
    }

    public function isAdmin() {
        return "{$this->role}";
    }


    public function likedPosts()
    {
        return $this->hasManyThrough('App\Models\Post', "App\Models\Like", "user", "id",
        "username", "id_post");
    }

    public function getPosts()
    {
        return $this->hasMany("App\Models\Post", "author", "username");
    }

    public function comments(){
        return $this->hasMany('App\Models\Comment', 'author', 'username');
    }
}
