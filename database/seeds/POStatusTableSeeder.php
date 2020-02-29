<?php

use Illuminate\Database\Seeder;

class POStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('po_status')->insert([
            'description' => 'Pending'
        ]);

        DB::table('po_status')->insert([
            'description' => 'Partial'
        ]);

        DB::table('po_status')->insert([
            'description' => 'Complete'
        ]);

    }
}
