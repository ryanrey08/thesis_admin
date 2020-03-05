<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


use DB;


class Payments extends Model
{
    
    protected $guarded = [];
    protected $table = 'payment';


    public function getPaymentMethods($transactionid) {
    	$paymentmethod = DB::table('payment_method')
    		->join('transaction', 'payment_method.id', '=', 'transaction.paymenttype')
    		->select('payment_method.*', 'transaction.id')
    		->where('transaction.id',  '=', $transactionid)
    		->limit(1)
    		->get();
    	return $paymentmethod;
    }

    public function updatePaymentRecord($transactionid) {
    	$record = DB::table('payment')
    		->select('*')
    		->where('payment.transactionid', '=', $transactionid)
    		->limit(1)
    		->get();
    	return $record;
    }

}
