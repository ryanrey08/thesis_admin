<?php

use Illuminate\Database\Seeder;

class ActionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('action')->insert([
            'description' => 'PO Created'
        ]);

        DB::table('action')->insert([
            'description' => 'Processed PO'
        ]);

        DB::table('action')->insert([
            'description' => 'PO Completed'
        ]);
    }
}
