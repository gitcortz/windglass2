<?php

use Illuminate\Database\Seeder;

class CustomerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       //\App\Customer::truncate();

       $faker = \Faker\Factory::create();

       for ($i = 0; $i < 10; $i++) {
           \App\Models\Customer::create([
               'name' => $faker->name, 
               'email' => $faker->email,
               'address' => $faker->address,
               //'city' => $faker->city,
               'phone' => $faker->e164PhoneNumber,
               'mobile' => $faker->e164PhoneNumber,
           ]);
       }
    }
}
