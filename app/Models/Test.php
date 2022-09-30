<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $fillable = [
		'text', 'date'
	];
	
	protected $dates = [
		'created_at','updated_at'
	];
}
