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
                ['name'=>'EDIT_PERMS'],
                ['name'=>'UPDATE_CATS'],
                //  articles
                ['name'=>'ADD_ARTICLES'],
                ['name'=>'UPDATE_ARTICLES'],
                ['name'=>'DELETE_ARTICLES'],
            //  blog
                ['name'=>'ADD_BLOG'],
                ['name'=>'UPDATE_BLOG'],
                ['name'=>'DELETE_BLOG'],
            ]
        );
    }
}
