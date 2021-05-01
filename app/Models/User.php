<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;
    protected $fillable = ['userkey', 'name', 'password', 'maxbidamount', 'gender', 'fund', 'created_at', 'updated_at'];
    protected $guarded = ['id'];
    protected $dates = ['created_at', 'updated_at'];
    protected $hidden = ['password'];

    public function itemusers() {
        return $this->hasMany(Itemuser::class)
            ->with('item');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

}
