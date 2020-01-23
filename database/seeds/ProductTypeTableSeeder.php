<?php

use Illuminate\Database\Seeder;

class ProductTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\ProductType::create([
            'name' => 'Cylinders',
        ]);
        \App\Models\ProductType::create([
            'name' => 'Empty Cylinders',
        ]);
        \App\Models\ProductType::create([
            'name' => 'Parts',
        ]);
    }
}
