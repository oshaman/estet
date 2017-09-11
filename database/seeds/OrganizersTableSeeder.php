<?php

use Illuminate\Database\Seeder;

class OrganizersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('organizers')->insert(
            [
                ['name' => 'Компания TOTISPHARMA GROUP', 'alias'=>'totispharma'],
                ['name' => 'Beauty Aestetics', 'alias'=>'beauty-aestetics'],
                ['name' => 'Institute Hyalual', 'alias'=>'institute-hyalual'],
                ['name' => 'Косметик Групп', 'alias'=>'kosmetik-grup'],
                ['name' => 'PURLES', 'alias'=>'purles'],
                ['name' => 'ELLA BACHE', 'alias'=>'ella-bache'],

            ]
        );
    }
}
