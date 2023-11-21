<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            [
                'name' => 'Mutation Rate',
                'value' => ''
            ],
            [
                'name' => 'Crossover Rate',
                'value' => ''
            ],
            [
                'name' => 'Maximum Generations',
                'value' => ''
            ]
        ]);
    }
}
