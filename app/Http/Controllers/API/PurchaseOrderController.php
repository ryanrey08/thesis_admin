<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;



use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderHasItems;
use App\Models\Item;
use App\Models\InventoryHistory;
use App\Models\Event;
use App\Models\POHistory;


use Carbon\Carbon;
use DB;
use Auth;
use Keygen;





class PurchaseOrderController extends Controller
{
    
    protected $po, $poitems;



    public function index() {

        return $this->po->getPOs();
    }


    public function __construct() {
        $this->po = new PurchaseOrder();
        $this->poitems = new PurchaseOrderHasItems();
    }



    public function store(Request $request) {

        DB::beginTransaction();

        try {
            
            $porderid = $this->generateID(PurchaseOrder::class, 9);

            $newPO = $this->po->create([
                'id' => $porderid,
                'expected_arrival' => $request->expected_arrival,
                'ref_number' => $request->ref_number,
                'sources_id' => $request->source['id'],
            ]);

            $sample = 0;

            foreach($request->selectedItems as $poitem) {
                $poItems = $this->poitems->create([
                    'purchase_order_id' => $porderid,
                    'item_id' => $poitem['id'],
                    'quantity' => $poitem['newQty']
                ]);
            }


            $po_history = new POHistory();

            $pohist = $po_history->create([
                'action_id' => 1,
                'purchase_order_id' => $newPO->id,
                'staff_id' => $request->staff['id'],
                'created_at' => Carbon::now()->toDateTimeString()
            ]);

            DB::commit();

        } catch(Exception $ex) {
            DB::rollback();
        }
    }


    public function update(Request $request, $id) {

        $porder = PurchaseOrder::findOrFail($id);


        $po_status = 3;

        DB::beginTransaction();

        try {

            $itm; $updItem; $notFound = true;

            foreach($request->poitems as $item) {

                $poitem = PurchaseOrderHasItems::where('item_id', $item['item_id'])->where('purchase_order_id', $id);
                // print_r("poitem: " . $poitem->item_id . "\n");

                print_r($item['item_id']);
                
                $itm = $poitem->update([
                    'received' => $item['received'],
                    'cancelled' => $item['cancelled'],
                    'rejected' => $item['rejected']
                ]);

                print_r("Itm: " . $itm . "\n");

                $inventory = Item::findOrFail($item['item_id']);

                $updItem = $inventory->update([
                    'quantity' => ($inventory->quantity + $item['received']),
                ]);

                print_r("UpdItem: " . $updItem . "\n");
                

                if( ($item['received'] + $item['cancelled'] + $item['rejected']) < $item['quantity'] && $notFound) {
                    
                    $po_status = 2;
                    // dd(($item['received'] + $item['cancelled'] + $item['rejected']) . $po_status);

                }

                $inv_history = new InventoryHistory();

                $history_entry = $inv_history->create([
                    'description' => $porder->id,
                    'description_type' => 1,
                    'quantity' => ($inventory->quantity + $item['received']),
                    'adjustments' => $item['received'],
                    'adjustment_type' => 1,
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'item_id' => $item['item_id'],
                    'staff_id' => $request->staff['id'],
                    'event_id' => 3
                ]);

                print_r("History: " . $history_entry . "\n" . "\n");


            }


            $pord = $porder->update([
                'po_status_id' => $po_status
            ]);

            // if($itm && $updItem && $pord){
            //     print_r("\n\nCommitted!");
            //     DB::commit();

            // } else {
            //     DB::rollback();
            // }

            // DB::rollback();
            DB::commit();
        } catch(Exception $ex){
            DB::rollback();
        }
        
    }



    protected function generateNumericKey($num) {
        $numericKey = strval(Keygen::numeric($num)->generate());

        while($numericKey[0] == '0') {
            $numericKey = strval(Keygen::numeric($num)->generate());
        }

        return $numericKey; 
    }

    protected function generateID($class, $num){
        $id = $this->generateNumericKey($num);

        // Ensure ID does not exist
        // Generate new one if ID already exists
        while ($class::whereId($id)->count() > 0 ) {
            $id = $this->generateNumericKey($num);
        }

        return $id;
    }


    public function searchPO() {
        if($query = \Request::get('po'))
            return $this->po->searchPO($query);
        else {
            return $this->po->getPOs();
        }
    }

    public function getPOItems($porderid) {
        return $this->poitems->getPOItems($porderid);
    }

    public function getPO($porderid) {
        return $this->poitems->getPO($porderid);
    }

    public function getPOHistory($id) {
         return $this->po->getPOHistory($id);
    }
}
