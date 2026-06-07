<?php

namespace App\Console\Commands;

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
        $this->info('Sincronizando schema...');

        Artisan::call('migrate', [
            '--path' => 'database/migrations/2026_06_06_220000_add_auth_tables_for_mysql.php',
            '--force' => true,
        ]);

        $this->line(Artisan::output());

        if (! Schema::hasColumn('users', 'security_question')) {
            $this->error('Colunas de segurança não foram criadas. Verifique a conexão com o banco.');

            return self::FAILURE;
        }

        $this->info('Populando perfis, permissões e usuários...');
        (new UserSeeder)->run();

        User::where('email', 'admin@helpdesk.com')->update([
            'password' => Hash::make('12345678'),
            'status' => 'Ativo',
            'profile' => 'Admin',
            'role' => 'admin',
            'security_question' => 'Qual o nome da sua primeira escola?',
            'security_answer' => 'objetivo',
        ]);

        $this->info('Setup concluído!');
        $this->table(['Campo', 'Valor'], [
            ['Login admin', 'admin@helpdesk.com'],
            ['Senha admin', '12345678'],
        ]);

        return self::SUCCESS;
    }
}
