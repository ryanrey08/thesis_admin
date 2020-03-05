<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



use DB;

class PurchaseOrderHasItems extends Model
{
    protected $guarded = [];
    protected $table = 'purchase_order_has_item';
    public $timestamps = false;





    public function getPOItems($porderid) {
    	// return $this->where('purchase_order_id', $porderid)->get();

    	$poitems = DB::table('purchase_order_has_item')
    		->join('item', 'purchase_order_has_item.item_id', '=', 'item.id')
    		->join('product_images', function($join) {
                $join->on('item.product_id', '=', 'product_images.product_id')
                    ->where('product_images.iscover', '=', '1');
            })
    		->select('purchase_order_has_item.*', 'item.name', 'product_images.name as imgname')
            ->where('purchase_order_id', $porderid)
    		->get();

    	return $poitems;
    }

      public function getPO($porderid) {
        // return $this->where('purchase_order_id', $porderid)->get();

       $porder = DB::table('purchase_order')
            ->join('sources', function($join) {
                $join->on('purchase_order.sources_id', '=', 'sources.id');
            })
             ->join('purchase_order_has_item', function($join) {
                $join->on('purchase_order.id', '=', 'purchase_order_has_item.purchase_order_id');
            })
              ->join('item', function($join) {
                $join->on('item.id', '=', 'purchase_order_has_item.item_id');
            })
            ->join('po_status', 'purchase_order.po_status_id', '=', 'po_status.id')
            ->select('purchase_order.*', 'sources.name as sourcename', 'sources.phone as phone','sources.address as address', 'purchase_order_has_item.quantity as quantity', 'purchase_order_has_item.item_id as item_id', 'item.price', 'po_status.description as postat')
            ->where('purchase_order.id', $porderid)->get();
        return $porder;
    }

    public function item() {
         return $this->belongsTo('App\Models\Item');
    }

    public function product() {
         return $this->belongsTo('App\Models\Product');
    }
}
