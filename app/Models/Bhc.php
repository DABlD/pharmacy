<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\BhcAttribute;
use App\Models\Rhu;

class Bhc extends Model
{
    use SoftDeletes, BhcAttribute;

    protected $fillable = [
        'name', 'code', 'region', 'municipality', 'rhu_id'
    ];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public function rhu(){
        return $this->hasOne(Rhu::class, 'id', 'rhu_id');
    }
}