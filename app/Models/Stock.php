<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Reorder;

class Stock extends Model
{
    protected $fillable = [
        'reorder_id',
        'lot_number',
        'expiry_date',
        'unit_price',
        'qty'
    ];

    protected $dates = [
        'expiry_date', 'created_at', 'updated_at'
    ];

    public function reorder(){
        return $this->hasOne(Reorder::class, 'id', 'reorder_id');
    }
}