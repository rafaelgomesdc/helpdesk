<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Mariana Souza Silva',
                'email' => 'admin@empresa.com',
                'password' => Hash::make('123456'),
                'profile' => 'Admin',
                'sector_id' => 'Tecnologia da Informação',
                'cargo_id' => 'Admin',
                'phone' => '(11) 98888-1111',
                'security_question' => 'Qual o nome da sua primeira escola?',
                'security_answer' => 'objetivo',
                'status' => 'Ativo',
            ],
            [
                'name' => 'Carlos Alberto Ferreira',
                'email' => 'carlos.suporte@empresa.com',
                'password' => Hash::make('123456'),
                'profile' => 'Técnico',
                'sector_id' => 'Tecnologia da Informação',
                'cargo_id' => 'Suporte Técnico',
                'phone' => '(11) 97777-2222',
                'security_question' => 'Qual é a sua cidade natal?',
                'security_answer' => 'santos',
                'status' => 'Ativo',
            ],
            [
                'name' => 'Juliana Silva Castro',
                'email' => 'juliana.financeiro@empresa.com',
                'password' => Hash::make('123456'),
                'profile' => 'Usuário',
                'sector_id' => 'Financeiro / Contábil',
                'cargo_id' => 'Analista Financeiro',
                'phone' => '(11) 95555-4444',
                'security_question' => 'Qual a marca do seu primeiro carro?',
                'security_answer' => 'fiat',
                'status' => 'Ativo',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                $user
            );
        }
    }
}
