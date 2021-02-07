<?php

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Branch::create([

            'name'          => 'BBU',
            'address'       => 'Bandar Baru Uda',
            'postcode'      => '80350',
            'city'          => 'johor bahru',
            'state'         => 'johor',
            'country'       => 'Malaysia',
            'phone_number'  => '0173519861',

        ]);

        Branch::create([

            'name'          => 'Adda Height',
            'address'       => 'Adda Height',
            'postcode'      => '80350',
            'city'          => 'johor bahru',
            'state'         => 'johor',
            'country'       => 'Malaysia',
            'phone_number'  => '0173519861',

        ]);

        Branch::create([

            'name'          => 'Kota Tinggi',
            'address'       => 'Kota Tinggi',
            'postcode'      => '80350',
            'city'          => 'Kota Tinggi',
            'state'         => 'johor',
            'country'       => 'Malaysia',
            'phone_number'  => '0173519861',
        ]);
    }
}
