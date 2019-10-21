<?php

namespace App;
use Eloquent;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
         'name', 'email', 'password', 'position', 'avatar', 'provider',
     ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isAdmin() {
    $st = false;
    if ($this->is_admin == 1) {
        $st = true;
    }
    return $st;
}
}
