<?php

use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $faker = Faker::create();

        User::create([
            'name'          =>  'admin',
            'country_code'  =>  '60',
            'mobile'        =>  '123456789',
            'email'         =>  'admin@admin.com',
            'password'      =>  bcrypt('password'),
            'status'        =>  'admin',
        ]);
    }
}
