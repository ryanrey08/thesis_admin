<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
   	protected $guarded = [];
    protected $table = 'user';

    public function address(){
    	return $this->hasMany(Address::class);
    }
}
