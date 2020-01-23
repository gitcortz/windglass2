<?php

use Illuminate\Database\Seeder;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\City::create([
            'name' => 'Mandaluyong City',
        ]);
        \App\Models\City::create([
            'name' => 'Pasig City',
        ]);
        
    }
}
