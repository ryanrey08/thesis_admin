<?php

use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('order')->insert([
            'id' => 34267589,
             'shipping_fee' => 150,
            'total' => 650,
            'users_id' => 12345678,
            'address_id' => 1,
            'order_status_id' => 1,
             'transaction_id' => 1234567890,
        ]);

        DB::table('orders')->insert([
             'id' => 99875321,
            'shipping_fee' => 200,
             'total' => 1350,
            'users_id' => 56545422,
            'address_id' => 2,
            'order_status_id' => 1,
            'transaction_id' => 9987654321,
        ]);
    }
}
