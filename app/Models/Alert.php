<?php

namespace App\Models;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use App\Models\Alert;

class Alert extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'message'
    ];

    protected $dates = [
        'created_at', 'deleted_at', 'updated_at'
    ];
}
