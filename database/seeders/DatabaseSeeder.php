<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(VoyagerDatabaseSeeder::class);
        $this->call(ClientsTableSeeder::class);
        $this->call(PhonesTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(InvoicesTableSeeder::class);
        
        
        
        $this->call(UsersTableSeeder::class);


    }
}
