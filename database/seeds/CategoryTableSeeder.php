<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('category')->insert([
            'description' => 'Shirts'
        ]);

        DB::table('category')->insert([
            'description' => 'Mugs'
        ]);

        DB::table('category')->insert([
            'description' => 'Caps'
        ]);

        DB::table('category')->insert([
            'description' => 'Bags'
        ]);
    }
}
