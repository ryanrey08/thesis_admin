<?php

use Illuminate\Database\Seeder;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('event')->insert([
            'description' => 'Manually Removed'
        ]);

        DB::table('event')->insert([
            'description' => 'Manually Added'
        ]);

        DB::table('event')->insert([
            'description' => 'PO Received'
        ]);

        DB::table('event')->insert([
            'description' => 'Fulfill Order'
        ]);

        
    }
}
