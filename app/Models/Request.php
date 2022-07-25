<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use App\Models\{Rhu, Medicine};

class Request extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id','reference','requested_by',
        'medicine_id','request_qty','unit_price',
        'amount','approved_qty','date_approved',
        'status', 'lot_number', 'expiry_date'
    ];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at', 'date_approved', 'expiry_date'
    ];

    public function rhu(){
        return $this->hasOne(Rhu::class, 'user_id', 'user_id');
    }

    public function medicine(){
        return $this->hasOne(Medicine::class);
    }

    public function reorder(){
        return $this->hasOne(Reorder::class, 'medicine_id', 'medicine_id');
    }
}
