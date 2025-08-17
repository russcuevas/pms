<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentsProof extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'property_id',
        'unit_id',
        'fullname',
        'unit',
        'email',
        'phone_number',
        'payment_proof',
    ];
}
