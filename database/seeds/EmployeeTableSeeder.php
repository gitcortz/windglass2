<?php

use Illuminate\Database\Seeder;

class EmployeeTableSeeder extends Seeder
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
           \App\Models\Employee::create([
               'first_name' => $faker->firstName, 
               'last_name' => $faker->lastName, 
               'email' => $faker->email,
               'address' => $faker->address,
               //'city' => $faker->city,
               'phone' => $faker->e164PhoneNumber,
               'mobile' => $faker->e164PhoneNumber,
           ]);
       }
    }
}
