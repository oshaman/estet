<?php

use Illuminate\Database\Seeder;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cities')->insert([
            ['name' => 'Украина'],
            ['name' => 'Италия'],
            ['name' => 'Испания'],
            ['name' => 'Грузия'],
            ['name' => 'Азербайджан'],
            ['name' => 'Россия'],
        ]);

    }
}
