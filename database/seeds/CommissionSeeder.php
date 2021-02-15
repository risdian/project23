<?php

use App\Models\Commission;
use App\Models\CommissionAttributes;
use Illuminate\Database\Seeder;

class CommissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Commission::create([

            'user_id'           =>  '1',
            'status'            =>  '1',
            'start_date'        =>  '2021-01-01 00:00:00',
            'date_end'          =>  '2021-12-31 23:59:00',

        ]);


        CommissionAttributes::create([

            'commission_id' => '1',
            'price'         => '2',
            'range_start'   => '1',
            'range_end'     => '100000',

        ]);

        CommissionAttributes::create([

            'commission_id' => '1',
            'price'         => '5',
            'range_start'   => '100001',
            'range_end'     => '300000',

        ]);

        CommissionAttributes::create([

            'commission_id' => '1',
            'price'         => '8',
            'range_start'   => '300001',
            'range_end'     => '500000',

        ]);


    }
}
