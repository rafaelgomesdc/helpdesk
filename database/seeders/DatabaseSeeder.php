<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Perfil;
use App\Models\Setor;
use App\Models\Cargo;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        /*
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        */

        // 1. Cadastrar os PERFIS
        Perfil::create([
            'nome' => 'admin',
            'descricao' => 'Acesso total ao sistema'
        ]);

        Perfil::create([
            'nome' => 'tecnico',
            'descricao' => 'Atendimento e resolução de chamados'
        ]);

        Perfil::create([
            'nome' => 'solicitante',
            'descricao' => 'Abertura e acompanhamento de chamados'
        ]);

        // 2. Cadastrar um SETOR e um CARGO básicos (necessário para cadastrar usuário)
        Setor::create([
            'nome' => 'TI - Tecnologia da Informação',
            'descricao' => 'Setor de suporte e desenvolvimento'
        ]);

        Cargo::create([
            'nome' => 'Administrador do Sistema',
            'descricao' => 'Responsável por todo o gerenciamento'
        ]);

        // 3. Cadastrar o USUÁRIO ADMINISTRADOR (para eu logar)
        Usuario::create([
            'nome' => 'Administrador Geral',
            'email' => 'admin@fatec.br',
            'senha' => Hash::make('123456'), // senha: 123456 (já criptografada)
            'contato' => '(18) 99999-0000',
            'setor_id' => 1, // pega o primeiro setor cadastrado acima
            'cargo_id' => 1, // pega o primeiro cargo cadastrado acima
            'perfil_id' => 1  // pega o perfil ADMIN cadastrado acima
        ]);
    }
}
