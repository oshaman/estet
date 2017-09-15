<?php

use Illuminate\Database\Seeder;

class EventsAdTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('eadvs')->insert(
            [
                ['title' => 'slider1'],
                ['title' => 'slider2'],
                ['title' => 'slider3'],
                ['title' => 'slider4'],
                ['title' => 'slider5'],
                ['title' => 'slider6'],
                ['title' => 'slider7'],
            ]
        );
    }
}
