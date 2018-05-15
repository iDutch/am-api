<?php

use Illuminate\Database\Seeder;

class CrossbarClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('crossbar_clients')->insert([
            'username' => 'Admin',
            'client_key' => bcrypt('!Limecat22'),
            'user_id' => 1,
        ]);
        DB::table('crossbar_clients')->insert([
            'username' => 'LedController',
            'client_key' => bcrypt('!Limecat22'),
            'user_id' => 1,
        ]);
        DB::table('crossbar_clients')->insert([
            'username' => 'App',
            'client_key' => bcrypt('!Limecat22'),
            'user_id' => 1,
        ]);
    }
}
