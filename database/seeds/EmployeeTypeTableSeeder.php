<?php

use Illuminate\Database\Seeder;

class EmployeeTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\EmployeeType::create([
            'name' => 'admin',
        ]);
        \App\Models\EmployeeType::create([
            'name' => 'office',
        ]);
        \App\Models\EmployeeType::create([
            'name' => 'rider',
        ]);
    }
}
