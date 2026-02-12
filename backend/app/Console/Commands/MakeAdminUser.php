<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MakeAdminUser extends Command
{
    protected $signature = 'handy:make-admin
                            {--name= : Nombre del administrador}
                            {--email= : Email (obligatorio)}
                            {--password= : Contraseña (si no se indica, se generará una)}';

    protected $description = 'Crea un usuario administrador con privilegios CRUD en el dashboard';

    public function handle(): int
    {
        $email = $this->option('email') ?? $this->ask('Email del administrador');

        if (empty($email)) {
            $this->error('El email es obligatorio.');
            return self::FAILURE;
        }

        if (User::where('email', $email)->exists()) {
            $user = User::where('email', $email)->first();
            $role = Role::where('slug', 'admin')->first();
            if ($role && $user->role_id !== $role->id) {
                $user->update(['role_id' => $role->id]);
                $this->info("El usuario {$email} ahora es administrador.");
                return self::SUCCESS;
            }
            $this->warn("El usuario {$email} ya existe y ya es administrador.");
            return self::SUCCESS;
        }

        $name = $this->option('name') ?? $this->ask('Nombre del administrador', 'Administrador');
        $password = $this->option('password') ?? $this->secret('Contraseña (dejar vacío para generar)');

        if (empty($password)) {
            $password = Str::random(12);
            $this->line('Contraseña generada: <info>' . $password . '</info>');
        }

        $role = Role::where('slug', 'admin')->first();
        if (! $role) {
            $this->error('No existe el rol "admin". Ejecuta: php artisan db:seed --class=RoleSeeder');
            return self::FAILURE;
        }

        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role_id' => $role->id,
        ]);

        $this->info("Administrador creado: {$email}");
        $this->line('Puede acceder al dashboard en: ' . url('/admin'));

        return self::SUCCESS;
    }
}
