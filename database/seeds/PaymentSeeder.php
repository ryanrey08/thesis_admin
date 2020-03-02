<?php

use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('payment_methods')->insert([
        	'name' => 'Cash on Delivery',
            'description' => 'Please ensure that you will pay the exact amount as the courier will deliver your item'
        ]);

        DB::table('payment_methods')->insert([
            'name' => 'Palawan Express',
            'description' => 'Once payment has been made, send receipt to sales@hanadulsetph.com or thru FB/hanadulsetph. ORDER ID + Receipt [palawan express]'
        ]);
    }
}
