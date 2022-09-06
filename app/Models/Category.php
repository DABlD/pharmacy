<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Medicine;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'admin_id'
    ];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public function medicines(){
        return $this->hasMany(Medicine::class);
    }
}