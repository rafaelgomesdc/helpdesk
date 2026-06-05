<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@helpdesk.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Técnico',
            'email' => 'tecnico@helpdesk.com',
            'password' => Hash::make('password'),
            'role' => 'technician',
        ]);

        User::create([
            'name' => 'Usuário',
            'email' => 'usuario@helpdesk.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);
    }
}