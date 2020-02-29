<?php

use Illuminate\Database\Seeder;

class VariantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('variant')->insert([
            'name' => 'Size'
        ]);

        DB::table('variant')->insert([
            'name' => 'Color'
        ]);
    }
}
