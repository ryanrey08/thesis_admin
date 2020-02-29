<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role')->insert([
            'description' => 'Administrator'
        ]);

        DB::table('role')->insert([
            'description' => 'Staff'
        ]);

        DB::table('role')->insert([
            'description' => 'Cashier'
        ]);

        DB::table('role')->insert([
            'description' => 'Data Administrator'
        ]);

        DB::table('role')->insert([
            'description' => 'Stock Keeper'
        ]);
    }
}
