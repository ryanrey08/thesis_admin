<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use DB;

class PurchaseOrder extends Model
{
    protected $guarded = [];
    protected $table = 'purchase_order';





    public function getPOs() {
    	// $porders = DB::table('purchase_order')
    	// 	->select('*')
    	// 	->paginate(5);
    	// return $porders;
    	$porder = DB::table('purchase_order')
    		->join('sources', function($join) {
                $join->on('purchase_order.sources_id', '=', 'sources.id');
            })
            ->join('po_status', 'purchase_order.po_status_id', '=', 'po_status.id')
            ->select('purchase_order.*', 'sources.name as sourcename', 'po_status.description as postat')
            ->latest()
            ->paginate(10);
    	return $porder;
    }


    public function searchPO($query) {
        $porder = DB::table('purchase_order')
    		->join('sources', function($join) {
                $join->on('purchase_order.sources_id', '=', 'sources.id');
            })
            ->select('purchase_order.*', 'sources.name as sourcename')
            ->where('purchase_order.id', 'LIKE', "%$query%")
            ->orWhere('sources.name', 'LIKE', "%$query%")
            ->orWhere('purchase_order.expected_arrival', 'LIKE', "%$query%")
            ->latest()
            ->paginate(10);

        return $porder;

    }

    public function getPOHistory($id) {
        $po_history = DB::table('po_history')
            ->join('action', function($join) {
                $join->on('po_history.action_id', '=', 'action.id');
            })
             ->join('staff', function($join) {
                $join->on('po_history.staff_id', '=', 'staff.id');
            })
            ->select('po_history.*', 'action.description as action', 'staff.name as staff_name')
            ->where('purchase_order_id', $id)
            ->get();
        return $po_history;
    }
}
