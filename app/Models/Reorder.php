<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\{Medicine};

class Reorder extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'user_id', 'medicine_id', 'point', 'stock'
    ];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public function medicine(){
        return $this->hasOne(Medicine::class, 'id', 'medicine_id');
    }
}
