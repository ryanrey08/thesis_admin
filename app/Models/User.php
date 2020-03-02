<?php

namespace App\Models;

use DB;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
   	protected $guarded = [];
    protected $table = 'users';

    public function getCustomer(){
    	$customer = DB::table('users')
    		->select('*')
    		->get();

    	return $customer;
    }

    public function address(){
    	return $this->hasMany(Address::class);
    }
}
