<?php

namespace App\Models;


use DB;

use Illuminate\Database\Eloquent\Model;

class Sources extends Model
{
    protected $guarded = [];
    protected $table = 'sources';
    public $timestamps = false;


    public function getSources(){
    	$sources = DB::table('sources')
    		->select('*')
    		->paginate(5);
    	return $sources;
   	}

   	public function getAllSources(){
    	$sources = DB::table('sources')
    		->select('*')
    		->get();
    	return $sources;
   	}
}
