<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class AcademicPeriodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          DB::table('academic_periods')
            ->insert([
                ["name" => "Semester I"],
                ["name" => "Semester II"],
                ["name" => "Semester III"],
                ["name" => "Semester IV"],
                ["name" => "Semester V"],
                ["name" => "Semester VI"],
                ["name" => "Semester VII"],
                ["name" => "Semester VIII"],
            ]);
    }
}
