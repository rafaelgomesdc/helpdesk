<?php

namespace App\Console\Commands;

use App\Models\Prioridade;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class HelpdeskSetup extends Command
{
    protected $signature = 'helpdesk:setup';

    protected $description = 'Sincroniza schema MySQL e dados iniciais do HelpDesk';

    public function handle(): int
    {
        $migrations = [
            '2026_06_06_220000_add_auth_tables_for_mysql.php',
            '2026_06_07_000001_create_ticket_support_tables.php',
        ];

        foreach ($migrations as $file) {
            Artisan::call('migrate', [
                '--path' => 'database/migrations/'.$file,
                '--force' => true,
            ]);
        }

        if (! Schema::hasColumn('users', 'security_question')) {
            $this->error('Colunas de segurança ausentes. Verifique DB_SOCKET no .env');

            return self::FAILURE;
        }

        $this->info('Populando dados iniciais...');
        (new UserSeeder)->run();

        User::where('email', 'admin@helpdesk.com')->update([
            'password' => Hash::make('12345678'),
            'status' => 'Ativo',
            'profile' => 'Admin',
            'role' => 'admin',
            'security_question' => 'Qual o nome da sua primeira escola?',
            'security_answer' => 'objetivo',
        ]);

        foreach ([
            ['nome' => 'Baixa', 'nivel' => 1, 'cor' => '#28a745'],
            ['nome' => 'Média', 'nivel' => 2, 'cor' => '#ffc107'],
            ['nome' => 'Alta', 'nivel' => 3, 'cor' => '#fd7e14'],
            ['nome' => 'Crítica', 'nivel' => 4, 'cor' => '#dc3545'],
        ] as $p) {
            Prioridade::updateOrCreate(['nome' => $p['nome']], $p);
        }

        Artisan::call('storage:link');

        $this->info('Setup concluído!');
        $this->table(['Campo', 'Valor'], [
            ['Login admin', 'admin@helpdesk.com'],
            ['Senha admin', '12345678'],
        ]);

        return self::SUCCESS;
    }
}
