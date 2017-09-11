<?php

use Illuminate\Database\Seeder;

class AdvertisingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('advertisings')->insert(
            [
                ['own'=>'doc', 'text'=>'reklama', 'placement'=>'main_1'],
                ['own'=>'doc', 'text'=>'reklama', 'placement'=>'main_2'],
                ['own' => 'doc', 'text' => 'reklama', 'placement' => 'main_3'],
                ['own'=>'doc', 'text'=>'reklama', 'placement'=>'sidebar'],
                ['own' => 'doc', 'text' => 'reklama', 'placement' => 'sidebar2'],
                ['own'=>'doc', 'text'=>'reklama', 'placement'=>'footer'],
                ['own'=>'patient', 'text'=>'reklama', 'placement'=>'main_1'],
                ['own'=>'patient', 'text'=>'reklama', 'placement'=>'main_2'],
                ['own'=>'patient', 'text'=>'reklama', 'placement'=>'sidebar'],
                ['own' => 'patient', 'text' => 'reklama', 'placement' => 'sidebar2'],
                ['own'=>'patient', 'text'=>'reklama', 'placement'=>'footer'],
            ]
        );
    }
}
