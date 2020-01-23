<?php

use Illuminate\Database\Seeder;

class BrandTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Brand::create([
            'name' => 'Philgas',
        ]);
        \App\Models\Brand::create([
            'name' => 'Solane',
        ]);
        \App\Models\Brand::create([
            'name' => 'SuperKalan',
        ]);
        \App\Models\Brand::create([
            'name' => 'Gasul',
        ]);
        \App\Models\Brand::create([
            'name' => 'Fiesta',
        ]);
        \App\Models\Brand::create([
            'name' => 'Liquigas',
        ]);
        \App\Models\Brand::create([
            'name' => 'Shine Gas',
        ]);
    }
}
