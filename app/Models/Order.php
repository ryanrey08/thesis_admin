<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use DB;

class Order extends Model
{
    protected $guarded = [];
	protected $table = 'orders';


	public function getOrders() {

		$transactions = DB::table('transactions')
			->join('payment_methods', 'transactions.paymenttype', '=', 'payment_methods.id')
			->select('transactions.id as transactionid', 'payment_methods.name as paymentmethod');

		$orders = DB::table('orders')
			->join('users', 'orders.userid', '=', 'users.id')
			->joinSub($transactions, 'transactions', function($join) {
				$join->on('orders.transactionid', '=', 'transactions.transactionid');
			})
			->join('order_status', 'orders.statusid', '=', 'order_status.id')
			->select('orders.*', 'users.name as customer', 'transactions.*', 'order_status.description as status')
			->latest()
			->get();

		return $orders;

	}

	public function getOrderStatus() {

		$status = DB::table('order_status')
			->select('*')
			->get();

		return $status;
	}
	
}
