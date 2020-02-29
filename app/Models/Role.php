<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $guarded = [];
    protected $table = 'role';
    public $timestamps = false;


    public function staff() {
    	return $this->belongsTo('App\User');
    }
}
