<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\Item;
use App\Models\InventoryHistory;

use DB;
use Auth;
use Keygen;
use Carbon\Carbon;



class InventoryController extends Controller
{
    protected $item, $item_history;

    public function index() {

        return $this->item->getItems();
    }


    public function __construct() {
        $this->item = new Item();
        $this->item_history = new InventoryHistory();

        date_default_timezone_set('Asia/Hong_Kong');
    }

    public function searchItem() {
        if($query = \Request::get('item'))
            return $this->item->searchItem($query);
        else {
            return $this->item->getItems();
        }
    }

    public function searchAllItem() {
        if($query = \Request::get('item'))
            return $this->item->searchAllItem($query);
        else {
            return $this->item->getAllItems();
        }
    }

    public function getProduct($id) {
    	return $this->item->getProduct($id);
    }

    public function getItem($id) {
    	return $this->item->getItem($id); 
    }

    public function getProdItem($id) {
        return $this->item->getProdItem($id); 
    }

    public function getAllItems() {
        return $this->item->getAllItems(); 
    }

    public function update(Request $request, $id) {
         $item = Item::findOrFail($id);

        DB::beginTransaction();

        try {

            // dd($request);

            $upd_qty = $item->quantity;

            if($request->updatetype == 1) {
                $upd_qty = $item->quantity + $request->newQty;
            } else {
                $upd_qty = $request->newQty;
            }

            $oldQty = $item->quantity;


            $oldItem = $item->update([
                'quantity' => $upd_qty
            ]);

            $event_type;

            if($upd_qty <= $oldQty) {
                $event_type = 1;
            } else {
                $event_type = 2;
            }

            $inv_history = new InventoryHistory();

            $history_entry = $inv_history->create([
                'description' => '',
                'description_type' => 0,
                'quantity' => $upd_qty,
                'adjustments' => $request->newQty,
                'adjustment_type' => $event_type,
                'created_at' => Carbon::now()->toDateTimeString(),
                'item_id' => $item->id,
                'staff_id' => $request->staff['id'],
                'event_id' => $event_type
            ]);

            if($oldItem && $history_entry){

                DB::commit();

            } else {
                DB::rollback();
            }

            DB::rollback();
        } catch(Exception $ex){
            DB::rollback();
        }
    }

    public function printInvoice() {

    }

    public function printPurchase() {
        
    }

    public function getHistory($id) {
        return $this->item_history->getHistory($id);
    }
}
