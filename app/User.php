<?php

namespace CodeShopping;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
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
}
