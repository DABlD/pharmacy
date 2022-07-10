<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class Data extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'medicine_id', 'transaction_types_id', 'reference', 
        'particulars', 'lot_number', 'qty', 
        'unit_price', 'amount', 'transaction_date', 'expiry_date'
    ];

    protected $dates = [
        'expiry_date', 'created_at', 'updated_at', 'deleted_at', 'transaction_date'
    ];
}
