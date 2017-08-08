<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'user1',
            'email' => 'user1'.'@gmail.com',
            'password' => bcrypt('user1user1'),
            'hometown' => 'Mumbai',
        ]);
        DB::table('users')->insert([
            'name' => 'user2',
            'email' => 'user2'.'@gmail.com',
            'password' => bcrypt('user2user2'),
            'hometown' => 'Mumbai',
        ]);
    }
}
