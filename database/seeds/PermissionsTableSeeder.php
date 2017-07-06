<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert(
            [
                ['name'=>'ADMIN_USERS'],
                ['name'=>'VIEW_ADMIN'],
                ['name'=>'EDIT_USERS'],
                ['name'=>'CONFIRMATION_DATA'],
                /*//  articles
                ['name'=>'ADD_ARTICLES'],
                ['name'=>'UPDATE_ARTICLES'],
                ['name'=>'DELETE_ARTICLES'],*/
            ]
        );
    }
}
