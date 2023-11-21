<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //  \App\Models\User::factory(500)->create();
        $this->call(PermissionTableSeeder::class);
        $this->call(CreateAdminUserSeeder::class);
        // $this->call(UsersTableSeeder::class);
        $this->call(DaysTableSeeder::class);
        // $this->call(SecurityQuestionsSeeder::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(AcademicPeriodsTableSeeder::class);

        // App data seeders
        $this->call(RoomsTableSeeder::class);
        $this->call(TimeslotsTableSeeder::class);
        $this->call(CoursesTableSeeder::class);
        $this->call(ProfessorsTableSeeder::class);
        $this->call(ClassesTableSeeder::class);
    }
}
