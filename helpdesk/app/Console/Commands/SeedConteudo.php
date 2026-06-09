<?php

namespace App\Console\Commands;

use App\Models\Artigo;
use App\Models\Categoria;
use App\Models\Faq;
use App\Models\User;
use Illuminate\Console\Command;

class SeedConteudo extends Command
{
    protected $signature   = 'helpdesk:seed-conteudo {--fresh : Apaga tudo antes de inserir}';
    protected $description = 'Popula FAQs e Artigos com dados de exemplo';

    public function handle(): int
    {
        if ($this->option('fresh')) {
            Faq::truncate();
            Artigo::truncate();
            $this->info('Tabelas limpas.');
        }

        // ── CATEGORIAS ───────────────────────────────
        $cat = Categoria::pluck('id', 'nome');

        // Garante as 5 categorias padrão
        foreach (['Hardware', 'Software', 'Rede', 'Acesso', 'Outros'] as $nome) {
            if (! isset($cat[$nome])) {
                $cat[$nome] = Categoria::create(['nome' => $nome])->id;
            }
        }

        // ── FAQs ─────────────────────────────────────
        $faqs = [
            [
                'pergunta'     => 'Como abrir um chamado de suporte?',
                'resposta'     => "Para abrir um chamado, acesse o menu lateral \"Abrir Chamado\" após fazer login.\n\n1. Clique em \"Abrir Chamado\" no menu lateral esquerdo.\n2. Preencha o título com uma descrição curta do problema.\n3. Detalhe o problema no campo \"Descrição\" — quanto mais informações, mais rápido o atendimento.\n4. Selecione a categoria e a prioridade adequadas.\n5. Clique em \"Enviar Chamado\".\n\nVocê receberá atualizações sobre o andamento diretamente na Central de Chamados.",
                'categoria_id' => $cat['Software'],
            ],
            [
                'pergunta'     => 'Qual o prazo de atendimento dos chamados?',
                'resposta'     => "Os prazos variam conforme a prioridade:\n\n• Crítica: até 2 horas\n• Alta: até 4 horas\n• Média: até 1 dia útil\n• Baixa: até 3 dias úteis\n\nChamados fora do horário comercial (8h–18h, seg–sex) serão atendidos no próximo dia útil, exceto os críticos.",
                'categoria_id' => $cat['Software'],
            ],
            [
                'pergunta'     => 'Como redefinir minha senha de acesso ao portal?',
                'resposta'     => "Para redefinir sua senha:\n\n1. Na tela de login, clique em \"Esqueceu a senha?\".\n2. Informe seu e-mail corporativo cadastrado.\n3. Responda a pergunta de segurança definida no cadastro.\n4. Digite e confirme a nova senha.\n5. Clique em \"Redefinir Senha\".\n\nSe não lembrar a resposta, entre em contato com o administrador do sistema.",
                'categoria_id' => $cat['Acesso'],
            ],
            [
                'pergunta'     => 'Meu computador não liga. O que fazer?',
                'resposta'     => "Antes de abrir um chamado, tente:\n\n1. Verifique se o cabo de energia está conectado corretamente.\n2. Confirme se há energia na tomada (teste outro equipamento).\n3. Pressione o botão liga/desliga por alguns segundos.\n4. Se ligar mas não concluir o boot, anote a mensagem de erro.\n\nSe nada funcionar, abra um chamado em Hardware com os detalhes.",
                'categoria_id' => $cat['Hardware'],
            ],
            [
                'pergunta'     => 'Como solicitar acesso a um sistema ou pasta de rede?',
                'resposta'     => "Solicitações de acesso devem ser feitas pelo portal:\n\n1. Abra um novo chamado na categoria \"Acesso\".\n2. Informe qual sistema ou recurso precisa ser acessado.\n3. Indique a justificativa e seu gestor responsável pela aprovação.\n4. O técnico entrará em contato para confirmar antes de liberar.",
                'categoria_id' => $cat['Acesso'],
            ],
            [
                'pergunta'     => 'Como conectar ao Wi-Fi corporativo?',
                'resposta'     => "Para conectar à rede Wi-Fi:\n\n1. Procure a rede com o nome fornecido pelo setor de TI.\n2. Insira as credenciais do seu e-mail corporativo.\n3. Aceite o certificado de segurança, se solicitado.\n\nSe não souber o nome ou credenciais, abra um chamado em \"Rede\".",
                'categoria_id' => $cat['Rede'],
            ],
            [
                'pergunta'     => 'Como instalar ou atualizar um programa?',
                'resposta'     => "Instalações requerem autorização da TI:\n\n1. Abra um chamado em \"Software\" descrevendo o programa e o motivo.\n2. Aguarde aprovação e agendamento pelo técnico.\n3. Nunca instale programas de fontes não autorizadas — isso compromete a segurança da rede.\n\nAtualizações de sistema são gerenciadas automaticamente fora do expediente.",
                'categoria_id' => $cat['Software'],
            ],
            [
                'pergunta'     => 'O que fazer quando a internet está lenta ou sem conexão?',
                'resposta'     => "Diagnóstico inicial:\n\n1. Reinicie o roteador/switch do setor (aguarde 30 segundos).\n2. Verifique se o cabo de rede está bem conectado.\n3. Teste em outro computador do mesmo setor.\n4. Verifique se outros colegas têm o mesmo problema.\n\nSe persistir, abra um chamado em \"Rede\" com detalhes dos equipamentos afetados.",
                'categoria_id' => $cat['Rede'],
            ],
            [
                'pergunta'     => 'Como exportar relatórios do sistema?',
                'resposta'     => "Para exportar relatórios:\n\n1. Acesse o Painel Executivo no menu lateral.\n2. Aplique os filtros desejados (período, categoria, status).\n3. Clique em \"Exportar CSV\" no canto superior direito.\n4. O arquivo será baixado automaticamente.\n\nPara impressão, recomendamos abrir no Excel, formatar e imprimir.",
                'categoria_id' => $cat['Software'],
            ],
            [
                'pergunta'     => 'Como atualizar meus dados cadastrais?',
                'resposta'     => "Para atualizar telefone, setor, cargo ou outras informações:\n\n1. Abra um chamado na categoria \"Acesso\" com os dados que precisam ser alterados.\n2. O administrador realizará a alteração e confirmará por e-mail.\n\nAtualmente, o próprio usuário não pode editar o perfil diretamente — isso é feito pelo administrador para garantir integridade.",
                'categoria_id' => $cat['Acesso'],
            ],
        ];

        $faqCount = 0;
        foreach ($faqs as $f) {
            Faq::firstOrCreate(['pergunta' => $f['pergunta']], $f);
            $faqCount++;
        }

        // ── ARTIGOS ──────────────────────────────────
        $admin = User::where('role', 'admin')->first();
        $tecnico = User::where('role', 'technician')->first();
        $authorId = $admin?->id ?? $tecnico?->id ?? 1;

        $artigos = [
            [
                'titulo'       => 'Como configurar e-mail corporativo no Outlook',
                'conteudo'     => "# Configuração do Outlook\n\nEste artigo explica como adicionar sua conta de e-mail corporativo no Microsoft Outlook.\n\n## Pré-requisitos\n- Microsoft Outlook 2016 ou superior instalado\n- Credenciais de e-mail fornecidas pela TI\n\n## Passo a passo\n\n1. Abra o Outlook e clique em **Arquivo > Adicionar Conta**.\n2. Digite seu e-mail corporativo e clique em **Conectar**.\n3. Selecione o tipo de conta: **Exchange** ou **IMAP** conforme indicado pela TI.\n4. Insira a senha quando solicitado.\n5. Aguarde a configuração automática ser concluída.\n6. Clique em **Concluir** e reinicie o Outlook.\n\n## Configuração manual (se necessário)\n\n- **Servidor de entrada:** mail.empresa.com.br (porta 993 / SSL)\n- **Servidor de saída:** smtp.empresa.com.br (porta 587 / TLS)\n\nEm caso de dúvidas, abra um chamado na categoria **Software**.",
                'categoria_id' => $cat['Software'],
                'author_id'    => $authorId,
            ],
            [
                'titulo'       => 'Procedimento de backup de arquivos pessoais',
                'conteudo'     => "# Backup de Arquivos Pessoais\n\nÉ essencial realizar backups regulares para evitar perda de dados importantes.\n\n## Política de backup da empresa\n\n- O servidor de arquivos realiza backup automático **diariamente às 23h**.\n- Backups locais são de **responsabilidade do colaborador**.\n- Arquivos na pasta `C:\\\\Documentos` **não** são incluídos no backup automático.\n\n## Como fazer backup manual\n\n### Opção 1 — Pasta de Rede\n1. Acesse `\\\\\\\\servidor\\\\backup-pessoal\\\\` no Explorer.\n2. Copie seus arquivos importantes para a pasta com seu nome de usuário.\n3. A pasta de rede é incluída no backup automático noturno.\n\n### Opção 2 — OneDrive Corporativo\n1. Faça login no OneDrive com suas credenciais corporativas.\n2. Sincronize a pasta Documentos clicando com botão direito > **Sempre manter neste dispositivo**.\n\n## Dica importante\n\nNunca armazene arquivos críticos apenas no desktop ou na área de trabalho local — esses locais **não** são incluídos no backup.",
                'categoria_id' => $cat['Software'],
                'author_id'    => $authorId,
            ],
            [
                'titulo'       => 'Guia de segurança da informação para colaboradores',
                'conteudo'     => "# Segurança da Informação — Boas Práticas\n\nTodos os colaboradores são responsáveis pela segurança das informações da empresa.\n\n## Regras essenciais\n\n### Senhas\n- Use senhas com no mínimo **8 caracteres**, combinando letras, números e símbolos.\n- **Nunca compartilhe** sua senha com colegas, nem mesmo com a TI.\n- Troque sua senha a cada **90 dias**.\n- Não use a mesma senha para sistemas pessoais e corporativos.\n\n### E-mail\n- Desconfie de e-mails com **links suspeitos** ou anexos inesperados.\n- Nunca informe dados pessoais ou senhas em resposta a e-mails.\n- Reporte e-mails suspeitos para ti@empresa.com.br.\n\n### Dispositivos\n- **Bloqueie** sua estação de trabalho sempre que se ausentar (`Win + L`).\n- Não conecte pendrives de origem desconhecida.\n- Não instale softwares sem autorização da TI.\n\n### Dados confidenciais\n- Não fotografe telas com informações sensíveis.\n- Documentos impressos devem ser destruídos na trituradora ao final do uso.",
                'categoria_id' => $cat['Acesso'],
                'author_id'    => $authorId,
            ],
            [
                'titulo'       => 'Resolução de problemas comuns de impressora',
                'conteudo'     => "# Problemas Comuns de Impressora\n\nEste artigo lista os problemas mais frequentes e como resolvê-los.\n\n## Impressora offline\n\n1. Verifique se a impressora está ligada e conectada à rede.\n2. No Windows, abra **Dispositivos e Impressoras**.\n3. Clique com botão direito na impressora > **Ver o que está imprimindo**.\n4. No menu, clique em **Impressora > Cancelar todos os documentos**.\n5. Em seguida: **Impressora > Usar impressora offline** (desmarque esta opção).\n\n## Impressão saindo cortada ou com qualidade ruim\n\n- Verifique o nível de toner/tinta em **Propriedades da Impressora**.\n- Limpe os cabeçotes de impressão pelo painel da impressora.\n- Confirme que o tipo de papel selecionado na impressão corresponde ao carregado.\n\n## Atolamento de papel\n\n1. Desligue a impressora.\n2. Abra as tampas traseira e frontal conforme o manual.\n3. Remova o papel com cuidado, sem rasgá-lo.\n4. Feche as tampas e ligue novamente.\n\nSe o problema persistir após estes passos, abra um chamado em **Hardware**.",
                'categoria_id' => $cat['Hardware'],
                'author_id'    => $authorId,
            ],
            [
                'titulo'       => 'Como acessar a VPN corporativa',
                'conteudo'     => "# Acesso à VPN Corporativa\n\nA VPN permite acessar sistemas internos de qualquer lugar com segurança.\n\n## Requisitos\n- Cliente VPN instalado (fornecido pela TI)\n- Credenciais de rede corporativa\n- Conexão à internet estável\n\n## Instalação do cliente VPN\n\n1. Solicite o instalador pelo portal de chamados (categoria **Acesso**).\n2. Execute o instalador com permissão de administrador.\n3. Na configuração inicial, insira o endereço do servidor fornecido pela TI.\n\n## Conexão\n\n1. Abra o cliente VPN na bandeja do sistema.\n2. Clique em **Conectar**.\n3. Informe usuário e senha corporativos.\n4. Aguarde a autenticação (pode levar até 30 segundos).\n5. O ícone ficará verde quando conectado.\n\n## Desconexão\n\nSempre desconecte a VPN ao terminar o trabalho remoto. Clique no ícone > **Desconectar**.\n\n## Problemas de conexão\n\n- Verifique sua conexão com a internet.\n- Tente reconectar após aguardar 1 minuto.\n- Se persistir, abra um chamado em **Rede**.",
                'categoria_id' => $cat['Rede'],
                'author_id'    => $authorId,
            ],
        ];

        $artigoCount = 0;
        foreach ($artigos as $a) {
            Artigo::firstOrCreate(['titulo' => $a['titulo']], $a);
            $artigoCount++;
        }

        $this->info("✅ {$faqCount} FAQs inseridas/verificadas.");
        $this->info("✅ {$artigoCount} Artigos inseridos/verificados.");

        return self::SUCCESS;
    }
}
