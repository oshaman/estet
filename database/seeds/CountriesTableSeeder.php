<?php

use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('countries')->insert([
            ['name' => 'Украина'],
            ['name' => 'Италия'],
            ['name' => 'Испания'],
            ['name' => 'Грузия'],
            ['name' => 'Азербайджан'],
            ['name' => 'Россия'],
        ]);
    }
}
