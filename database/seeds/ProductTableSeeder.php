<?php

use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Product::create([
            'name' => 'Super Kalan, Snap-On, 2.7',
            'unit_price' => 220.00,
            'producttype_id' => 1,
            'brand_id' => 3,
        ]);
        \App\Models\Product::create([
            'name' => 'Philgas, Pol-Valve, 11',
            'unit_price' => 650.00,
            'producttype_id' => 1,
            'brand_id' => 1,
        ]);
        \App\Models\Product::create([
            'name' => 'Shine Gas, Snap-On, 2.7',
            'unit_price' => 220.00,
            'producttype_id' => 1,
            'brand_id' => 7,
        ]);

    }
}
