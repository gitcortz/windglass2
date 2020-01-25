<?php

use Illuminate\Database\Seeder;

class StockTransferTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\StockTransfer::create([
            'from_branch_id' => 1,
            'to_branch_id' => 2,
            'transfer_status_id' => 1,
        ]);
    }
}
