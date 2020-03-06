<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Productvariant;
use App\Models\Transactions;
use App\Models\ProductTransactions;
use App\Models\Item;
use App\Models\Payments;

use DB;
use Keygen;

class POSController extends Controller
{

       protected $product, $provar, $transactions, $proTrans, $items, $payments;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->product->getPublishedProducts();
    }

     public function __construct() {
        $this->product = new Product();
        $this->transactions = new Transactions();
        $this->proTrans = new ProductTransactions();
        $this->items = new Item();
        $this->payments = new Payments();
    }

      public function getProVariants($id) {
        return $this->product->getProVariants($id);
    }


    public function checkout(Request $request) {

        DB::beginTransaction();

        try {
            $transactionID = $this->generateID(Transactions::class, 8);

            $newPayments = $this->payments->create([
                'payment_method_id' => 3,
                'amount' => $request->payment,
                'ispaid' => 1,
            ]);

            $newTransactions = $this->transactions->create([
                'id' => $transactionID,
                // 'type' => 1,
                'payment_id' => $newPayments->id,
                'transaction_type_id' => 1,
            ]);

            foreach($request->selectedItems as $selectedItem) {

                $newSelectedItem = $this->proTrans->create([
                    'item_product_id' => $selectedItem['product']['product_id'],
                    'item_id' => $selectedItem['product']['id'],
                    'price' => $selectedItem['product']['price'],
                    'quantity' => $selectedItem['quantity'],
                    'transaction_id' => $transactionID
                ]);

                DB::update('UPDATE item SET quantity = ? where id = ?', [($selectedItem['product']['quantity'] - $selectedItem['quantity']), $selectedItem['product']['id']]);
                
            }

            

            DB::commit();
        } catch(Exception $ex) {
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
