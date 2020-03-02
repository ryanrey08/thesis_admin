<?php

use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('order_status')->insert([
            'description' => 'Pending'
        ]);

        DB::table('order_status')->insert([
            'description' => 'Processing'
        ]);

        DB::table('order_status')->insert([
            'description' => 'Shipping'
        ]);

        DB::table('order_status')->insert([
            'description' => 'Delivery'
        ]);

        DB::table('order_status')->insert([
            'description' => 'Complete'
        ]);
    }
}
