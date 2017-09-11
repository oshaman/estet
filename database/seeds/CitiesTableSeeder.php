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
            ['name' => 'Киев', 'country_id' => '1'],
            ['name' => 'Днепр', 'country_id' => '1'],
            ['name' => 'Львов', 'country_id' => '1'],
            ['name' => 'Харьков', 'country_id' => '1'],
            ['name' => 'Одесса', 'country_id' => '1'],

            ['name' => 'Рим', 'country_id' => '2'],
            ['name' => 'Милан', 'country_id' => '2'],
            ['name' => 'Фиорентина', 'country_id' => '2'],
            ['name' => 'Турин', 'country_id' => '2'],
            ['name' => 'Неаполь', 'country_id' => '2'],

            ['name' => 'Барселона', 'country_id' => '3'],
            ['name' => 'Мадрид', 'country_id' => '3'],
            ['name' => 'Севилья', 'country_id' => '3'],
            ['name' => 'Бильбао', 'country_id' => '3'],
            ['name' => 'Валенсия', 'country_id' => '3'],

            ['name' => 'Тбилиси', 'country_id' => '4'],
            ['name' => 'Батуми', 'country_id' => '4'],
            ['name' => 'Кутаиси', 'country_id' => '4'],
            ['name' => 'Боржоми', 'country_id' => '4'],
            ['name' => 'Мцхета', 'country_id' => '4'],

            ['name' => 'Баку', 'country_id' => '5'],
            ['name' => 'Гянджа', 'country_id' => '5'],
            ['name' => 'Шеки', 'country_id' => '5'],
            ['name' => 'Сумгайыт', 'country_id' => '5'],
            ['name' => 'Мингечевир', 'country_id' => '5'],

            ['name' => 'Москва', 'country_id' => '6'],
            ['name' => 'Санкт-Петербург', 'country_id' => '6'],
            ['name' => 'Новосибирск', 'country_id' => '6'],
            ['name' => 'Екатеринбург', 'country_id' => '6'],
            ['name' => 'Нижний Новгород', 'country_id' => '6'],
        ]);

    }
}
