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
            'name' => 'Milan',
            'directory' => $path.'/Dest/Milan',

        ]);
       DB::table('dest')->insert([
            'name' => 'Rome',
            'directory' => $path.'/Dest/Rome',
        ]);
    }
}
