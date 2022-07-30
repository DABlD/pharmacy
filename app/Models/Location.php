<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use App\Traits\LocationAttribute;
use App\Models\Location;

class Location extends Model
{
    use LocationAttribute;

    protected $fillable = [
        'location', 'contact'
    ];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];
}
