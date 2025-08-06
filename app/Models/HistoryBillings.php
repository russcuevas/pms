<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryBillings extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_id',
        'property_id',
        'tenant_name',
        'tenant_phone_number',
        'tenant_email',
        'account_number',
        'soa_no',
        'for_the_month_of',
        'statement_date',
        'due_date',
        'rental',
        'water',
        'electricity',
        'parking',
        'foam',
        'previous_balance',
        'amount',
        'total_balance_to_pay',
        'total_payment',
        'current_electricity',
        'previous_electricity',
        'consumption_electricity',
        'rate_per_kwh_electricity',
        'total_electricity',
        'current_water',
        'previous_water',
        'consumption_water',
        'rate_per_cu_water',
        'total_water',
        'status',
    ];
}
