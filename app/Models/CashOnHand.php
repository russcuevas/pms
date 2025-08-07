<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashOnHand extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'total_cash_amount',
    ];
}
