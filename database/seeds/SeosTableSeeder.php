<?php

use Illuminate\Database\Seeder;

class SeosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('seos')->insert(
            [
                ['uri'=>'/'],
                ['uri'=>'goroscop'],
                ['uri'=>'doctor/statyi'],
                ['uri'=>'meropriyatiya'],
                ['uri'=>'doctor/blog'],
                ['uri'=>'catalog/vrachi'],
                ['uri'=>'catalog/kliniki'],
                ['uri'=>'catalog/distributory'],
                ['uri'=>'catalog/brendy'],
                ['uri'=>'search'],
                ['uri'=>'404'],
            ]
        );
    }
}
