<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_id',
        'property_id',
        'tenant_id',
        'amount',
        'for_the_month_of',
        'reference_number',
        'mode_of_payment',
        'type',
        'is_approved',
    ];
}
