<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Crear rol de administrador si no existe
        $adminRole = Role::firstOrCreate(
            ['slug' => 'admin'],
            [
                'name' => 'Administrador',
                'description' => 'Acceso completo al sistema'
            ]
        );

        // Crear usuario administrador
        $admin = User::firstOrCreate(
            ['email' => 'admin@handy.com'],
            [
                'name' => 'Administrador',
                'password' => bcrypt('admin123'),
                'role_id' => $adminRole->id,
                'phone' => '555-000-0000',
                'address' => 'Oficina Principal'
            ]
        );

        // Crear usuario de prueba (cliente)
        $clienteRole = Role::firstOrCreate(
            ['slug' => 'cliente'],
            [
                'name' => 'Cliente',
                'description' => 'Usuario regular que solicita servicios'
            ]
        );

        User::firstOrCreate(
            ['email' => 'cliente@handy.com'],
            [
                'name' => 'Cliente Prueba',
                'password' => bcrypt('cliente123'),
                'role_id' => $clienteRole->id,
                'phone' => '555-111-2222',
                'address' => 'Dirección de prueba'
            ]
        );

        $this->command->info('Usuarios de prueba creados:');
        $this->command->info('Admin: admin@handy.com / admin123');
        $this->command->info('Cliente: cliente@handy.com / cliente123');
    }
}
