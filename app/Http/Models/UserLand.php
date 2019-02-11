<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class UserLand extends Model
{
	const UPDATED_AT = null;

    protected $fillable = ['user', 'land'];

    protected $table = 'user_land';

    public function land()
    {
        return $this->hasOne('App\Http\Models\Land', 'land', 'land.id');
    }

    public function user()
    {
        return $this->hasOne('App\Http\Models\User', 'user', 'user.id');
    }
}

