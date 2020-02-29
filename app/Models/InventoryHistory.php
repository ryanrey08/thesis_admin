<?php

namespace App\Models;

use DB;

use Illuminate\Database\Eloquent\Model;

class InventoryHistory extends Model
{
    protected $guarded = [];
    protected $table = 'inventory_history';
    public $timestamps = false;

    public function getHistory($id){
    	 $history = DB::table('inventory_history')
            ->join('event', function($join) {
                $join->on('inventory_history.event_id', '=', 'event.id');
            })
             ->join('item', function($join) {
                $join->on('item.id', '=', 'inventory_history.item_id');
            })
              ->join('staff', function($join) {
                $join->on('staff.id', '=', 'inventory_history.staff_id');
            })
            // ->join('po_status', 'purchase_order.po_status_id', '=', 'po_status.id')
            ->select('inventory_history.*', 'event.description as event_description', 'item.quantity as quantity', 'staff.name as staff_name')
            ->where('inventory_history.item_id', $id)->get();
        return $history;
    }
}
