<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function locations()
    {
        return $this->belongsToMany('App\Models\Location')
          ->as('location_user')
          ->withPivot('id', 'user_id', 'location_id');
    }

    public function modules()
    {
        return $this->belongsToMany('App\Models\Module')
          ->as('module_user')
          ->withPivot('id', 'user_id', 'module_id');
    }

    public static function boot(){
        parent::boot();

        User::deleting(function($user) {
            $user->active = 0;
            $user->save();
        });

        User::restoring(function ($user) {
            $user->active = 1;
            $user->save();
        });
    }
}
