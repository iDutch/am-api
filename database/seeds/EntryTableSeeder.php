<?php

use Illuminate\Database\Seeder;

class EntryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Entry::class, 17)->create([
            'schedule_id' => 1,
        ]);
    }
}
