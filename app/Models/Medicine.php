<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Traits\MedicineAttribute;
use App\Models\{Category, Reorder};

class Medicine extends Model
{
    use MedicineAttribute, SoftDeletes;

    protected $fillable = [
        'user_id', 'category_id', 'image', 'code', 'brand',
        'name', 'packaging', 'unit_price', 'cost_price'
    ];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public function category(){
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function reorder(){
        return $this->hasOne(Reorder::class);
    }
}
