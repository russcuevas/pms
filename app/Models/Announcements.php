<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcements extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'admins_id',
        'announcement_subject',
        'announcement_message',
        'is_approved'
    ];
}
