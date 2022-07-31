<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use App\Models\{Bhc, TransactionType, Reorder};

class Data extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'medicine_id', 'transaction_types_id', 'reference', 
        'particulars', 'lot_number', 'qty', 
        'unit_price', 'amount', 'transaction_date', 
        'expiry_date', 'user_id', 'bhc_id'
    ];

    //NOTE!!! MEDICINE_ID IS ACTUALLY REORDER ID
    //NOTE!!! MEDICINE_ID IS ACTUALLY REORDER ID
    //NOTE!!! MEDICINE_ID IS ACTUALLY REORDER ID

    protected $dates = [
        'expiry_date', 'created_at', 'updated_at', 'deleted_at', 'transaction_date'
    ];

    public function transaction_type(){
        return $this->hasOne(TransactionType::class, 'id', 'transaction_types_id');
    }

    public function bhc(){
        return $this->hasOne(Bhc::class, 'id', 'bhc_id');
    }

    public function reorder(){
        return $this->hasOne(Reorder::class, 'id', 'medicine_id');
    }
}