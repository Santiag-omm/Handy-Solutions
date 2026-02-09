<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $role = Role::where('slug', 'admin')->first();
        if (! $role) {
            return;
        }

        User::firstOrCreate(
            ['email' => 'admin@handyplus.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('password'),
                'role_id' => $role->id,
            ]
        );
    }
}
