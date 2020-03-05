<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Item extends Model
{
    protected $guarded = [];
    protected $table = 'item';
    public $timestamps = false;




    public function getProduct($productid) {
        $product = DB::table('item')
            ->select('*')
            ->where('product_id', '=', $productid)
            ->get();

        return $product;
    }

    public function getItem($itemid) {
    	$item = DB::table('product')
    		->join('product_images', function($join) {
            	$join->on('product.id', '=', 'product_images.product_id')
            		->where('product_images.iscover', '=', '1');
            })
            ->join('item', 'product.id', '=', 'item.product_id')
            ->select('item.*',  'product.threshold', 'product.discount_type', 'product.discount_value', 'product_images.name as imgname')
            ->where('item.id', '=', $itemid)
            ->limit(1)
            ->get();
        return $item;
    }

    public function getProdItem($itemid) {
        $item = DB::table('product')
            ->join('product_images', function($join) {
                $join->on('product.id', '=', 'product_images.product_id')
                    ->where('product_images.iscover', '=', '1');
            })
            ->join('item', 'product.id', '=', 'item.product_id')
            ->select('item.*', 'product.discount_type', 'product.discount_value', 'product_images.name as imgname')
            ->where('item.product_id', '=', $itemid)
            ->get();
        return $item;
    }

    public function getAllItems() {
        $item = DB::table('product')
            ->join('product_images', function($join) {
                $join->on('product.id', '=', 'product_images.product_id')
                    ->where('product_images.iscover', '=', '1');
            })
            ->join('item', 'product.id', '=', 'item.product_id')
            ->select('item.*', 'product.threshold', 'product.discount_type', 'product.discount_value', 'product_images.name as imgname')
            ->get();
        return $item;
    }
    
    public function getItems() {
    	// $items = DB::table('item')
    	// 	->select('*')
    	// 	->orderBy('item.name')
     //        ->paginate(10);
    	// return $items;
        $item = DB::table('product')
            ->join('product_images', function($join) {
                $join->on('product.id', '=', 'product_images.product_id')
                    ->where('product_images.iscover', '=', '1');
            })
            ->join('item', 'product.id', '=', 'item.product_id')
            ->select('item.*', 'product.threshold', 'product.discount_type', 'product.discount_value', 'product_images.name as imgname')
            ->paginate(10);
        return $item;
    }

    public function searchItem($query) {
        $items = DB::table('item')
            ->select('*')
            ->where('id', 'LIKE', "%$query%")
            ->orWhere('name', 'LIKE', "%$query%")
            ->orWhere('price', 'LIKE', "%$query%")
            ->orWhere('quantity', 'LIKE', "%$query%")
            // ->orWhere('unit', 'LIKE', "%$query%")
            ->paginate(10);
        return $items;
    }

    public function searchAllItem($query) {
        $items = DB::table('item')
            ->select('*')
            ->where('id', 'LIKE', "%$query%")
            ->orWhere('name', 'LIKE', "%$query%")
            ->orWhere('price', 'LIKE', "%$query%")
            ->orWhere('quantity', 'LIKE', "%$query%")
            ->get();
            // ->orWhere('unit', 'LIKE', "%$query%")
        return $items;
    }

     public function product() {
        return $this->belongsTo('App\Models\Product');
    }

    public function purchase_order_has_item(){
         return $this->hasMany('App\Models\PurchaseOrderHasItems');
    }

}
