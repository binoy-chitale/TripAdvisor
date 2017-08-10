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
            'directory' => $path.'/Dest/Paris',
        ]);
       DB::table('dest')->insert([
            'name' => 'Melbourne',
            'directory' => $path.'/Dest/Melbourne',

        ]);
       DB::table('dest')->insert([
            'name' => 'Berlin',
            'directory' => $path.'/Dest/Berlin',
        ]);
       DB::table('dest')->insert([
            'name' => 'London',
            'directory' => $path.'/Dest/London',
        ]);
       DB::table('dest')->insert([
            'name' => 'New-York',
            'directory' => $path.'/Dest/New-York',
        ]);
    }
}
