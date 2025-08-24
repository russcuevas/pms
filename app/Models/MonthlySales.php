<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlySales extends Model
{
    use HasFactory;

        protected $fillable = [
        'unit_id',
        'property_id',
        'amount',
    ];
}
