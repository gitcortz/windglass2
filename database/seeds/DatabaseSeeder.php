<?php

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
        $this->call(UserTableSeeder::class);
        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(ProductTypeTableSeeder::class);   
        $this->call(BrandTableSeeder::class);
        $this->call(EmployeeTypeTableSeeder::class);
     
        $this->call(CitiesTableSeeder::class);
        $this->call(BranchTableSeeder::class);

        //$this->call(CustomerTableSeeder::class);
        //$this->call(EmployeeTableSeeder::class);
        //$this->call(ProductTableSeeder::class);
        //$this->call(StockTableSeeder::class);
        
    }
}
