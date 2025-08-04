<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Tenants extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'fullname',
        'username',
        'password',
        'email',
        'phone_number',
        'address',
        'move_in_date',
        'move_out_date',
        'unit_id',
        'property_id',
        'otp_code',
        'is_approved'
    ];
}
