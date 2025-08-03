<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admins extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'fullname',
        'username',
        'password',
        'email',
        'phone_number',
        'address',
        'property_id',
        'is_approved'
    ];
}
