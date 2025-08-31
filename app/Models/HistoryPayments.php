<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryPayments extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_id',
        'property_id',
        'billings_id',
        'tenant_code',
        'tenant_name',
        'tenant_phone_number',
        'tenant_email',
        'amount',
        'for_the_month_of',
        'reference_number',
        'mode_of_payment',
        'type',
        'is_approved',
    ];
}
