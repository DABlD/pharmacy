<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use App\Traits\RxAttribute;
use App\Models\Rx;

class Rx extends Model
{
    // use ;
    protected $fillable = [
        'ticket_number','patient_id','patient_name',
        'contact','address','amount','date', 'doctor_id',
        'item_code','item_name','item_description','price','qty','lot_number'
    ];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at', 'date'
    ];
}
