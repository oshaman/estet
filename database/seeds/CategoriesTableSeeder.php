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
                ['name' => 'Практика', 'alias'=>'praktika'],
                ['name' => 'Эксперты', 'alias'=>'eksperty'],
                ['name' => 'Дерматология', 'alias'=>'dermatologiya'],
                ['name' => 'Косметология', 'alias'=>'kosmetologia'],
                ['name' => 'Пластическая хирургия', 'alias'=>'plasticheskaya-hirurgiya'],
                ['name' => 'Трихология', 'alias'=>'trihologiya'],
                ['name' => 'Стоматология', 'alias'=>'stomatologiya'],
                ['name' => 'Венерология', 'alias'=>'venerologiya'],
                ['name' => 'Гинекология', 'alias'=>'ginekologiya'],
                ['name' => 'Урология', 'alias'=>'urologiya'],
                ['name' => 'Эндокринология', 'alias'=>'endokrinologiya'],
                ['name' => 'Диета и питание', 'alias'=>'dieta-i-pitanie'],
                ['name' => 'Красота и здоровье', 'alias'=>'krasota-i-zdorovie'],
                ['name' => 'Медицина и лечение', 'alias'=>'medicina-i-lechenie'],
                ['name' => 'Полезные советы', 'alias'=>'poleznyie-sovety'],
                ['name' => 'Интересные факты', 'alias'=>'interesnye-fakty'],
                ['name' => 'Психология', 'alias'=>'psihologiya'],

            ]
        );
    }
}