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
                ['name'=>'UPDATE_TAGS'],
//                articles
                ['name'=>'ADD_ARTICLES'],
                ['name'=>'UPDATE_ARTICLES'],
                ['name'=>'DELETE_ARTICLES'],
//                blog
                ['name'=>'ADD_BLOG'],
                ['name'=>'UPDATE_BLOG'],
                ['name'=>'DELETE_BLOG'],
//                establishment
                ['name'=>'UPDATE_ESTABLISHMENT'],
//                goroscop
                ['name'=>'UPDATE_GOROSCOP'],
//                menu
                ['name'=>'UPDATE_MENUS'],
//                comments
                ['name'=>'UPDATE_COMMENTS'],
//                premium
                ['name'=>'UPDATE_PREMIUMS'],
//                geo
                ['name'=>'UPDATE_GEO'],
            ]
        );
    }
}
