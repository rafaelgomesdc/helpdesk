<?php

namespace Database\Seeders;

use App\Models\Cargo;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Setor;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $ti = Setor::updateOrCreate(['nome' => 'Tecnologia da Informação'], ['descricao' => 'Setor de TI']);
        $fin = Setor::updateOrCreate(['nome' => 'Financeiro / Contábil'], ['descricao' => 'Setor financeiro']);

        $adminCargo = Cargo::updateOrCreate(
            ['nome' => 'Admin', 'setor_id' => $ti->id],
            ['descricao' => 'Administrador do sistema']
        );
        $suporteCargo = Cargo::updateOrCreate(
            ['nome' => 'Suporte Técnico', 'setor_id' => $ti->id],
            ['descricao' => 'Suporte de TI']
        );
        $analistaCargo = Cargo::updateOrCreate(
            ['nome' => 'Analista Financeiro', 'setor_id' => $fin->id],
            ['descricao' => 'Análise financeira']
        );

        $permissoes = [
            ['name' => 'usuarios.listar', 'description' => 'Listar usuários'],
            ['name' => 'usuarios.criar', 'description' => 'Criar usuários'],
            ['name' => 'usuarios.editar', 'description' => 'Editar usuários'],
            ['name' => 'usuarios.excluir', 'description' => 'Excluir usuários'],
            ['name' => 'tickets.listar', 'description' => 'Listar chamados'],
            ['name' => 'tickets.atender', 'description' => 'Atender chamados'],
        ];

        $permIds = [];
        foreach ($permissoes as $p) {
            $permIds[] = Permission::updateOrCreate(['name' => $p['name']], $p)->id;
        }

        $adminRole = Role::updateOrCreate(
            ['name' => 'Administrador'],
            ['description' => 'Acesso total ao sistema']
        );
        $adminRole->permissions()->sync($permIds);

        $tecnicoRole = Role::updateOrCreate(
            ['name' => 'Técnico'],
            ['description' => 'Atendimento de chamados']
        );
        $tecnicoRole->permissions()->sync(
            Permission::whereIn('name', ['tickets.listar', 'tickets.atender'])->pluck('id')
        );

        $users = [
            [
                'name' => 'Mariana Souza Silva',
                'email' => 'admin@helpdesk.com',
                'password' => Hash::make('12345678'),
                'profile' => 'Admin',
                'setor_id' => $ti->id,
                'cargo_id' => $adminCargo->id,
                'role_id' => $adminRole->id,
                'phone' => '(11) 98888-1111',
                'address' => 'Av. Brasil, 1000 - Presidente Prudente/SP',
                'security_question' => 'Qual o nome da sua primeira escola?',
                'security_answer' => 'objetivo',
                'status' => 'Ativo',
            ],
            [
                'name' => 'Carlos Alberto Ferreira',
                'email' => 'carlos.suporte@helpdesk.com',
                'password' => Hash::make('12345678'),
                'profile' => 'Técnico',
                'setor_id' => $ti->id,
                'cargo_id' => $suporteCargo->id,
                'role_id' => $tecnicoRole->id,
                'phone' => '(11) 97777-2222',
                'address' => 'Rua das Flores, 200 - Presidente Prudente/SP',
                'security_question' => 'Qual é a sua cidade natal?',
                'security_answer' => 'santos',
                'status' => 'Ativo',
            ],
            [
                'name' => 'Juliana Silva Castro',
                'email' => 'juliana.financeiro@helpdesk.com',
                'password' => Hash::make('12345678'),
                'profile' => 'Usuário',
                'setor_id' => $fin->id,
                'cargo_id' => $analistaCargo->id,
                'role_id' => null,
                'phone' => '(11) 95555-4444',
                'address' => 'Rua XV de Novembro, 500 - Presidente Prudente/SP',
                'security_question' => 'Qual a marca do seu primeiro carro?',
                'security_answer' => 'fiat',
                'status' => 'Ativo',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(['email' => $user['email']], $user);
        }
    }
}
