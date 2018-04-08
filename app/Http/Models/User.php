<?php

namespace App\Http\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    const UPDATED_AT = null;
    
    protected $casts = [
        'active'   => 'boolean'
    ];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'active', 'user_type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function user_type()
    {
        return $this->hasOne('App\Http\Models\UserType', 'id');
    }
    
    public function attributes()
    {
        return $this->hasMany('App\Http\Models\UserAttributeValue', 'user');
    }
}
