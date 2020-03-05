<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {

        $this->call(RolesTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(VariantsTableSeeder::class);
        $this->call(StaffTableSeeder::class);
        $this->call(POStatusTableSeeder::class);
        $this->call(EventsTableSeeder::class);
        $this->call(ActionTableSeeder::class);
        $this->call(CMSTableSeeder::class);
        $this->call(OrderStatusSeeder::class);
        $this->call(PaymentSeeder::class);
        
    }
}
