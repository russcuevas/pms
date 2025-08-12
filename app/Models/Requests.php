<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requests extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'tenant_id',
        'unit_id',
        'subject_request',
        'subject_message',
        'status',
        'is_approved',
    ];
}
