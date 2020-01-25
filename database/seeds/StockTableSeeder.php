<?php

use Illuminate\Database\Seeder;

class StockTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Stock::create([
            'branch_id' => 1,
            'product_id' => 1,
            'initial_stock' => 0,
            'current_stock' => 50,
            'stock_status_id' => 1,
        ]);
        \App\Models\Stock::create([
            'branch_id' => 2,
            'product_id' => 1,
            'initial_stock' => 0,
            'current_stock' => 20,
            'stock_status_id' => 1,
        ]);
    }
}
