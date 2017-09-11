<?php

use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tags')->insert(
            [
                ['name'=>'Дерматовенерология', 'alias'=>'dermatovenerologiya'],
                ['name'=>'Гинекология', 'alias'=>'ginekologiya'],
                ['name'=>'Аллергология', 'alias'=>'alergologiya'],
                ['name'=>'Пластическая хирургя', 'alias'=>'plasticheskaya-hirurgiya'],
                ['name'=>'Трихология', 'alias'=>'trihologiya'],
                ['name'=>'Дерматология', 'alias'=>'dermatologiya'],
                ['name'=>'Косметология', 'alias'=>'kosmetologiya'],
                ['name'=>'Эстетическая хирургия', 'alias'=>'esteticheskaya-hirurgiya'],
            ]
        );
    }
}
