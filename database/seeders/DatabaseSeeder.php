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

        $user1 = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password123'), 
        ]);
        $user2 = User::factory()->create([
            'name' => 'Editar',
            'email' => 'editar@gmail.com',
            'password' => Hash::make('password123'), 
        ]);
        $role = Role::create(['name' => 'admin']);
        $user1->assignRole($role);

        $role = Role::create(['name' => 'editar']);
        $user2->assignRole($role);
    }
}
