<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserTableSeeder::class);
        $this->call(DockerSeeder::class);
        $this->call(RequestStatusesTable::class);
        $this->call(SettingsSeeder::class);
    }
}
