<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use DB;

class Order extends Model
{
    protected $guarded = [];
	protected $table = 'order';


	public function getOrders() {

		$transactions = DB::table('transaction')
			->join('payment_method', 'transaction.payment_id', '=', 'payment_method.id')
			->select('transaction.id as transaction_id', 'payment_method.name as paymentmethod');

		$orders = DB::table('order')
			->join('users', 'order.users_id', '=', 'users.id')
			->joinSub($transactions, 'transaction', function($join) {
				$join->on('order.transaction_id', '=', 'transaction.transaction_id');
			})
			->join('order_status', 'order.order_status_id', '=', 'order_status.id')
			->select('order.*', 'users.name as customer', 'transaction.*', 'order_status.description as status')
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
