<?php

use Illuminate\Database\Seeder;

class BranchTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    $faker = \Faker\Factory::create();

       for ($i = 0; $i < 10; $i++) {
           \App\Models\Branch::create([
               'code' => "BR".$i, 
               'name' => "Branch ".$i, 
               'email' => $faker->email,
               'address' => $faker->address,
               'city_id' => 1,
               'phone' => $faker->e164PhoneNumber,
               'mobile' => $faker->e164PhoneNumber,
           ]);
       }
    }
}
