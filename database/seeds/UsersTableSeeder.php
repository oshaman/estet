<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
            [
                ['email'=>'guest@mail.com', 'password'=>bcrypt('111222'), 'verified'=>1, 'email_token'=>'qwe'],
                ['email'=>'moderator@mail.com', 'password'=>bcrypt('111222'), 'verified'=>1, 'email_token'=>'qwe1'],
                ['email'=>'admin@mail.com', 'password'=>bcrypt('111222'), 'verified'=>1, 'email_token'=>'qwe2'],
                ['email'=>'author@mail.com', 'password'=>bcrypt('111222'), 'verified'=>1, 'email_token'=>'qwe3'],
            ]
        );
    }
}
