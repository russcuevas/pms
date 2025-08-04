<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billings extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_id',
        'property_id',
        'tenant_id',
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
        'total_balance_to_pay',
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
        'is_approved',
    ];
}
