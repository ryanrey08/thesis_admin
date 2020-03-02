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
        DB::table('orders')->insert([
            'id' => 34267589,
            'procartid' => 1,
            'transactionid' => 1234567890,
            'userid' => 12345678,
            'addressid' => 1,
            'statusid' => 1,
            'shippingfee' => 150,
            'total' => 650
        ]);

        DB::table('orders')->insert([
             'id' => 99875321,
            'procartid' => 2,
            'transactionid' => 9987654321,
            'userid' => 56545422,
            'addressid' => 2,
            'statusid' => 1,
            'shippingfee' => 200,
            'total' => 1350
        ]);
    }
}
