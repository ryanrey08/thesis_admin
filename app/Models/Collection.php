<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use DB;

class Collection extends Model
{
    protected $guarded = [];
    protected $table = 'collection';
    public $timestamps = false;


    public function getCollections() {
    	$collections = DB::table('collection')
    		->select('*')
    		->get();

    	return $collections;
    }
}
