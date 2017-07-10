<?php

use Illuminate\Database\Seeder;

class SpecialtiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('specialties')->insert(
            [
                ['name'=>'Дерматовенеролог'],
                ['name'=>'Гинеколог'],
                ['name'=>'Аллерголог'],
                ['name'=>'Пластический хирург'],
                ['name'=>'Трихолог'],
                ['name'=>'Дерматолог'],
                ['name'=>'Косметолог'],
                ['name'=>'Флеболог'],
                ['name'=>'Эстетический хирург'],
            ]
        );
    }
}
