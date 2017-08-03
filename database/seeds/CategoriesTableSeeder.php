<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert(
            [
                ['name' => 'Практика'],
                ['name' => 'Эксперты'],
                ['name' => 'Последние'],
                ['name' => 'Дерматология'],
                ['name' => 'Косметология'],
                ['name' => 'Пластическая хирургия'],
                ['name' => 'Трихология'],
                ['name' => 'Стоматология'],
                ['name' => 'Венерология'],
                ['name' => 'Гинекология'],
                ['name' => 'Урология'],
                ['name' => 'Эндокринология'],
                ['name' => 'Диета и питание'],
                ['name' => 'Красота и здоровье'],
                ['name' => 'Медицина и лечение'],
                ['name' => 'Полезные советы'],
                ['name' => 'Интересные факты'],

            ]
        );
    }
}