<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'date',
        'salaries',
        'labor_for_repair',
        'materials',
        'food',
        'taxes',
        'miscellaneous',
        'water_electricity',
        'refund',
        'office_supplies',
        'remarks',
        'total',
        'is_approved'
    ];
}
