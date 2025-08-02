<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Host extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'fullname',
        'username',
        'password',
        'email',
        'phone_number',
        'address'
    ];
}
