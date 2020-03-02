<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


use DB;


class Payments extends Model
{
    
    protected $guarded = [];
    protected $table = 'payments';


    public function getPaymentMethods($transactionid) {
    	$paymentmethod = DB::table('payment_methods')
    		->join('transactions', 'payment_methods.id', '=', 'transactions.paymenttype')
    		->select('payment_methods.*', 'transactions.id')
    		->where('transactions.id',  '=', $transactionid)
    		->limit(1)
    		->get();
    	return $paymentmethod;
    }

    public function updatePaymentRecord($transactionid) {
    	$record = DB::table('payments')
    		->select('*')
    		->where('payments.transactionid', '=', $transactionid)
    		->limit(1)
    		->get();
    	return $record;
    }

}
