<?php

namespace CodeShopping\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, SoftDeletes;

    protected $dates = ["deleted_at"];
    protected $fillable = ["name", "email", "password"];
    protected $hidden = ["password", "remember_token"];

    public function fill(array $attributes)
    {
        !isset($attributes["password"]) ?: $attributes["password"] = bcrypt($attributes["password"]);
        return parent::fill($attributes);
    }

    public function getJWTIdentifier()
    {
        return $this->id;
    }

    public function getJWTCustomClaims()
    {
        return [
            "name" => $this->name,
            "email" => $this->email
        ];
    }
}
