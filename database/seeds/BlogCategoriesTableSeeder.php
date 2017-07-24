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
            ]
        );
    }
}
