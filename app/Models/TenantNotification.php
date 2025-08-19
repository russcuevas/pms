<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenantNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'property_id',
        'type',
        'title',
        'message',
        'url',
        'is_view',
        'extra',
    ];
}
