<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestToManager extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'admins_id',
        'request_subject',
        'request_message',
        'is_approved'
    ];
}
