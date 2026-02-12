<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            ServicioSeeder::class,
            FaqSeeder::class,
            AdminSeeder::class,
        ]);
    }
}
