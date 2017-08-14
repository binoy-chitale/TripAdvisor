<?php

use Illuminate\Database\Seeder;

class DestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = storage_path();
        DB::table('dest')->insert([
            'name' => 'Paris',
            'directory' => 'app/Dest/Paris/Paris.txt',
        ]);
       DB::table('dest')->insert([
            'name' => 'Melbourne',
            'directory' => 'app/Dest/Melbourne/melbourne.txt',

        ]);
       DB::table('dest')->insert([
            'name' => 'Berlin',
            'directory' => 'app/Dest/Berlin/berlin.txt',
        ]);
       DB::table('dest')->insert([
            'name' => 'London',
            'directory' => 'app/Dest/London/london.txt',
        ]);
       DB::table('dest')->insert([
            'name' => 'New-York',
            'directory' => 'app/Dest/NewYork/newyork.txt',
        ]);
    }
}
