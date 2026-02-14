<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Solo ejecutar si la tabla está completamente vacía (primera instalación)
        if (Role::count() > 0) {
            $this->command->info('La tabla de roles ya contiene datos. Omitiendo seeder.');
            return;
        }

        $roles = [
            ['name' => 'Administrador', 'slug' => 'admin', 'description' => 'Acceso total al panel'],
            ['name' => 'Técnico', 'slug' => 'tecnico', 'description' => 'Gestión de órdenes asignadas'],
            ['name' => 'Cliente', 'slug' => 'cliente', 'description' => 'Solicitudes y seguimiento'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }

        $this->command->info('Se han creado ' . count($roles) . ' roles iniciales.');
    }
}
