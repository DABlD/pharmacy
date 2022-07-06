<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Traits\RhuAttribute;
use App\Models\User;

class Rhu extends Model
{
    use RhuAttribute, SoftDeletes;

    protected $fillable = [
        'company_name', 'company_code', 'contact_personnel'
    ];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public function setCompanyCodeAttribute($value) {
        $num = random_int(100000, 999999);
        $this->attributes['company_code'] = $num;
    }

    public function  user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
