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
            'parent_id'     =>  '0',
        ]);

        User::create([
            'name'          =>  'Sale Expert',
            'country_code'  =>  '60',
            'mobile'        =>  '9876543221',
            'email'         =>  'sale@expert.com',
            'password'      =>  bcrypt('password'),
            'status'        =>  'sale_expert',
            'parent_id'     =>  '1',
        ]);

        User::create([
            'name'          =>  'personal shopper',
            'country_code'  =>  '60',
            'mobile'        =>  '987654321',
            'email'         =>  'personal@shopper.com',
            'password'      =>  bcrypt('password'),
            'status'        =>  'personal_shopper_1',
            'parent_id'     =>  '2',
        ]);

        User::create([
            'name'          =>  'agent',
            'country_code'  =>  '60',
            'mobile'        =>  '987652314321',
            'email'         =>  'agent@agent.com',
            'password'      =>  bcrypt('password'),
            'status'        =>  'personal_shopper_2',
            'parent_id'     =>  '3',
        ]);
    }
}
