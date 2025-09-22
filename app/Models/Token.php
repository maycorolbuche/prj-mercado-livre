<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    protected $fillable = [
        'code',
        'access_token',
        'client_id',
        'client_secret',
        'redirect_uri',
        'user_id'
    ];
}
