<?php

use Illuminate\Database\Seeder;

class PremiumTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('premia')->insert(
            [
//                clinics
                ['name'=>'prem1', 'category' => 'clinic'],
                ['name'=>'prem2', 'category' => 'clinic'],
//                distributors
                ['name'=>'prem1', 'category' => 'distributor'],
                ['name'=>'prem2', 'category' => 'distributor'],
//                    brand
                ['name'=>'prem1', 'category' => 'brand'],
                ['name'=>'prem2', 'category' => 'brand'],
//                    events
                ['name'=>'prem1', 'category' => 'event'],
                ['name'=>'prem2', 'category' => 'event'],

            ]
        );
    }
}
