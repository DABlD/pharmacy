<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Traits\MedicineAttribute;
use App\Models\Category;

class Medicine extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id', 'image', 'code', 'brand',
        'name', 'packaging', 'unit_price', 'cost_price',
        'reorder_point'
    ];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public function medicines(){
        return $this->hasOne(Category::class);
    }
}
