<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TurnOver extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'admin_fullname',
        'turn_over_money',
        'is_approved',
    ];
}
