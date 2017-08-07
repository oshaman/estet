<?php

use Illuminate\Database\Seeder;

class BlogCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('blog_categories')->insert(
            [
                ['name' => 'Практика', 'alias'=>'praktika'],
                ['name' => 'Эксперты', 'alias'=>'eksperty'],
                ['name' => 'Последние', 'alias'=>'poslednie'],
                ['name' => 'Дерматология', 'alias'=>'dermatologiya'],
                ['name' => 'Косметология', 'alias'=>'kosmetologia'],
                ['name' => 'Пластическая хирургия', 'alias'=>'plasticheskaya-hirurgiya'],
                ['name' => 'Трихология', 'alias'=>'trihologiya'],
                ['name' => 'Стоматология', 'alias'=>'stomatologiya'],
                ['name' => 'Венерология', 'alias'=>'venerologiya'],
                ['name' => 'Гинекология', 'alias'=>'ginekologiya'],
                ['name' => 'Урология', 'alias'=>'urologiya'],
                ['name' => 'Эндокринология', 'alias'=>'endokrinologiya'],
            ]
        );
    }
}
