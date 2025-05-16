<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // Crear roles si no existen
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $editorRole = Role::firstOrCreate(['name' => 'editar']);
        $userRole = Role::firstOrCreate(['name' => 'usuario']);

        // Usuario Administrador
        $user1 = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password123'),
            ]
        );
        $user1->assignRole($adminRole);

        // Usuario Editor
        $user2 = User::firstOrCreate(
            ['email' => 'editar@gmail.com'],
            [
                'name' => 'Editar',
                'password' => Hash::make('password123'),
            ]
        );
        $user2->assignRole($editorRole);

        // Usuario Normal
        $user3 = User::firstOrCreate(
            ['email' => 'usuario@gmail.com'],
            [
                'name' => 'Usuario',
                'password' => Hash::make('password123'),
            ]
        );
        $user3->assignRole($userRole);

        // Crear usuarios adicionales con factory si no existen
        if (User::count() < 8) {
            User::factory(5)->create()->each(function ($user) use ($userRole) {
                $user->assignRole($userRole);
            });
        }
    }
}
