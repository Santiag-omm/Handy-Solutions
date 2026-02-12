<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'Administrador', 'slug' => 'admin', 'description' => 'Acceso total al panel'],
            ['name' => 'Técnico', 'slug' => 'tecnico', 'description' => 'Gestión de órdenes asignadas'],
            ['name' => 'Cliente', 'slug' => 'cliente', 'description' => 'Solicitudes y seguimiento'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(
                ['slug' => $role['slug']],
                $role
            );
        }
    }
}
