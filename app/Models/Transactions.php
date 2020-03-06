<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use DB;

class Transactions extends Model
{
    
    protected $guarded = [];
    protected $table = 'transaction';


    public function getItemsInTransaction($transactionid) {
        $items = DB::table('products_transaction')
        	->join('item', 'products_transaction.itemid', '=', 'item.id')
        	->select('products_transaction.*', 'item.name')
        	->where('transactionid', '=', $transactionid)
        	->get();

       	return $items;
    }

}
