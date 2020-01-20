<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \App\User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $faker = \Faker\Factory::create();

        // Let's make sure everyone has the same password and 
        // let's hash it before the loop, or else our seeder 
        // will be too slow.
        $password = Hash::make('admin');

        \App\User::create([
            'name' => 'Administrator',
            'email' => 'admin@admin.com',
            'password' => $password,
        ]);

    }
}
