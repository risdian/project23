<?php

use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

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

        $user = User::create([
            'name'          =>  'super admin',
            'country_code'  =>  '60',
            'mobile'        =>  '123456789',
            'email'         =>  'super_admin@admin.com',
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

        $role = Role::create(['name' => 'Super Admin']);

        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);

    }
}
