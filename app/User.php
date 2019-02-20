<?php

namespace CodeShopping;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ["name", "email", "password"];
    protected $hidden = ["password", "remember_token"];

    public static function createCustom($attributes = array())
    {
        !isset($attributes["password"]) ?: $attributes["password"] = bcrypt($attributes["password"]);
        return parent::create($attributes);
    }
}
