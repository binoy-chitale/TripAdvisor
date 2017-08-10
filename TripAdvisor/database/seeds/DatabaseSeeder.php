<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(UserTableSeeder::class);
         $this->call(DestTableSeeder::class);
         $this->call(AttractionSeeder::class);
         $this->call(BerlinSeeder::class);
         $this->call(LondonSeeder::class);
         $this->call(MelbourneSeeder::class);
         $this->call(NYSeeder::class);
    }
}
