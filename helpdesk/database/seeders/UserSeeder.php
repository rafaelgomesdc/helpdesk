<?php

namespace Database\Seeders;

use App\Models\Cargo;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Setor;
use App\Models\User;
use App\Models\Categoria;
use App\Models\Prioridade;
use App\Models\Faq;
use App\Models\Artigo;
use App\Models\Ticket;
use App\Models\Comentario;
use App\Models\TicketHistory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $driver = DB::connection()->getDriverName();
        if ($driver === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = OFF;');
        } else {
            DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        }

        Comentario::truncate();
        TicketHistory::truncate();
        Ticket::truncate();
        Faq::truncate();
        Artigo::truncate();
        User::truncate();
        Role::truncate();
        Permission::truncate();
        Cargo::truncate();
        Setor::truncate();
        Categoria::truncate();
        Prioridade::truncate();

        if ($driver === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = ON;');
        } else {
            DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
        }

        // -------------------------------------------------------------------------
        // 1. SETORES E CARGOS
        // -------------------------------------------------------------------------
        $ti = Setor::create(['nome' => 'Tecnologia da Informação', 'descricao' => 'Setor de suporte, redes, infraestrutura e desenvolvimento']);
        $rh = Setor::create(['nome' => 'Recursos Humanos', 'descricao' => 'Gestão de pessoas, contratações e departamento pessoal']);
        $fin = Setor::create(['nome' => 'Financeiro e Contabilidade', 'descricao' => 'Contas a pagar/receber, tesouraria e conciliação contábil']);
        $sac = Setor::create(['nome' => 'Atendimento ao Cliente', 'descricao' => 'Relacionamento, pós-venda e ouvidoria']);
        $vendas = Setor::create(['nome' => 'Vendas e Marketing', 'descricao' => 'Comercial, publicidade e novos negócios']);

        $cargoAdmin = Cargo::create(['nome' => 'Administrador de Sistemas', 'setor_id' => $ti->id, 'descricao' => 'Gestão e administração da infraestrutura de TI']);
        $cargoSuporte = Cargo::create(['nome' => 'Técnico de Suporte N1', 'setor_id' => $ti->id, 'descricao' => 'Atendimento e suporte ao usuário final']);
        $cargoInfra = Cargo::create(['nome' => 'Analista de Redes', 'setor_id' => $ti->id, 'descricao' => 'Administração de redes e telecomunicações']);
        
        $cargoAnalistaRh = Cargo::create(['nome' => 'Analista de RH', 'setor_id' => $rh->id, 'descricao' => 'Processos de recrutamento, seleção e treinamento']);
        $cargoAssistenteAdmin = Cargo::create(['nome' => 'Assistente Administrativo', 'setor_id' => $vendas->id, 'descricao' => 'Apoio nas rotinas administrativas do setor comercial']);
        $cargoAnalistaContabil = Cargo::create(['nome' => 'Analista de Contabilidade', 'setor_id' => $fin->id, 'descricao' => 'Faturamento, impostos e obrigações acessórias']);

        // -------------------------------------------------------------------------
        // 2. PERMISSÕES E PERFIS (ROLES)
        // -------------------------------------------------------------------------
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
            $permIds[] = Permission::create($p)->id;
        }

        $adminRole = Role::create(['name' => 'Administrador', 'description' => 'Acesso total a todas as configurações e módulos do sistema']);
        $adminRole->permissions()->sync($permIds);

        $tecnicoRole = Role::create(['name' => 'Técnico', 'description' => 'Fila de atendimento de suporte técnico e base de conhecimento']);
        $tecnicoRole->permissions()->sync(
            Permission::whereIn('name', ['tickets.listar', 'tickets.atender'])->pluck('id')
        );

        // -------------------------------------------------------------------------
        // 3. COLABORADORES (USERS)
        // -------------------------------------------------------------------------
        $mariana = User::create([
            'name' => 'Mariana Souza Silva',
            'email' => 'admin@helpdesk.com',
            'password' => Hash::make('12345678'),
            'profile' => 'Admin',
            'setor_id' => $ti->id,
            'cargo_id' => $cargoAdmin->id,
            'role_id' => $adminRole->id,
            'phone' => '(11) 98888-1111',
            'address' => 'Av. Brasil, 1000 - Presidente Prudente/SP',
            'security_question' => 'Qual o nome da sua primeira escola?',
            'security_answer' => 'objetivo',
            'status' => 'Ativo',
        ]);

        $carlos = User::create([
            'name' => 'Carlos Alberto Ferreira',
            'email' => 'carlos.suporte@helpdesk.com',
            'password' => Hash::make('12345678'),
            'profile' => 'Técnico',
            'setor_id' => $ti->id,
            'cargo_id' => $cargoSuporte->id,
            'role_id' => $tecnicoRole->id,
            'phone' => '(11) 97777-2222',
            'address' => 'Rua das Flores, 200 - Presidente Prudente/SP',
            'security_question' => 'Qual é a sua cidade natal?',
            'security_answer' => 'santos',
            'status' => 'Ativo',
        ]);

        $marcos = User::create([
            'name' => 'Marcos Oliveira Mendes',
            'email' => 'marcos.infra@helpdesk.com',
            'password' => Hash::make('12345678'),
            'profile' => 'Técnico',
            'setor_id' => $ti->id,
            'cargo_id' => $cargoInfra->id,
            'role_id' => $tecnicoRole->id,
            'phone' => '(11) 99123-4567',
            'address' => 'Av. Washington Luiz, 850 - Presidente Prudente/SP',
            'security_question' => 'Qual o nome do seu primeiro animal de estimação?',
            'security_answer' => 'rex',
            'status' => 'Ativo',
        ]);

        $juliana = User::create([
            'name' => 'Juliana Silva Castro',
            'email' => 'juliana.financeiro@helpdesk.com',
            'password' => Hash::make('12345678'),
            'profile' => 'Usuário',
            'setor_id' => $fin->id,
            'cargo_id' => $cargoAnalistaContabil->id,
            'role_id' => null,
            'phone' => '(11) 95555-4444',
            'address' => 'Rua XV de Novembro, 500 - Presidente Prudente/SP',
            'security_question' => 'Qual a marca do seu primeiro carro?',
            'security_answer' => 'fiat',
            'status' => 'Ativo',
        ]);

        $leticia = User::create([
            'name' => 'Letícia Santos Neves',
            'email' => 'leticia.rh@helpdesk.com',
            'password' => Hash::make('12345678'),
            'profile' => 'Usuário',
            'setor_id' => $rh->id,
            'cargo_id' => $cargoAnalistaRh->id,
            'role_id' => null,
            'phone' => '(18) 99876-5432',
            'address' => 'Rua José Bonifácio, 120 - Presidente Prudente/SP',
            'security_question' => 'Qual o sobrenome de solteira da sua mãe?',
            'security_answer' => 'santos',
            'status' => 'Ativo',
        ]);

        $bruno = User::create([
            'name' => 'Bruno Lima Rocha',
            'email' => 'bruno.pendente@helpdesk.com',
            'password' => Hash::make('12345678'),
            'profile' => 'Usuário',
            'setor_id' => $rh->id,
            'cargo_id' => $cargoAnalistaRh->id,
            'role_id' => null,
            'phone' => '(18) 99765-4321',
            'address' => 'Av. Coronel Marcondes, 2400 - Presidente Prudente/SP',
            'security_question' => 'Qual a sua comida favorita?',
            'security_answer' => 'lasanha',
            'status' => 'Pendente',
        ]);

        $fernanda = User::create([
            'name' => 'Fernanda Costa Souza',
            'email' => 'fernanda.rejeitada@helpdesk.com',
            'password' => Hash::make('12345678'),
            'profile' => 'Usuário',
            'setor_id' => $vendas->id,
            'cargo_id' => $cargoAssistenteAdmin->id,
            'role_id' => null,
            'phone' => '(18) 99111-2222',
            'address' => 'Rua Major Felício Tarabay, 300 - Presidente Prudente/SP',
            'security_question' => 'Qual o nome do seu melhor amigo de infância?',
            'security_answer' => 'pedro',
            'status' => 'Rejeitado',
        ]);

        // -------------------------------------------------------------------------
        // 4. CATEGORIAS E PRIORIDADES
        // -------------------------------------------------------------------------
        $catHardware = Categoria::create(['nome' => 'Hardware', 'descricao' => 'Problemas físicos em computadores, monitores, impressoras e periféricos']);
        $catSoftware = Categoria::create(['nome' => 'Software & Sistemas', 'descricao' => 'Erros em programas, instalações, ERP e atualizações']);
        $catRedes = Categoria::create(['nome' => 'Redes & Internet', 'descricao' => 'Instabilidade na Wi-Fi, problemas de cabo, VPN e telefonia IP']);
        $catAcessos = Categoria::create(['nome' => 'Acessos & Contas', 'descricao' => 'Reset de senhas, liberação de pastas de rede e novos acessos']);
        $catTelefonia = Categoria::create(['nome' => 'Telefonia & Infraestrutura', 'descricao' => 'Ramais IP, aparelhos telefônicos e cabeamento estruturado']);

        $prioridadeBaixa = Prioridade::create(['nome' => 'Baixa', 'nivel' => 1, 'cor' => '#6c757d']);
        $prioridadeMedia = Prioridade::create(['nome' => 'Média', 'nivel' => 2, 'cor' => '#0d6efd']);
        $prioridadeAlta = Prioridade::create(['nome' => 'Alta', 'nivel' => 3, 'cor' => '#ffc107']);
        $prioridadeCritica = Prioridade::create(['nome' => 'Crítica', 'nivel' => 4, 'cor' => '#dc3545']);

        // -------------------------------------------------------------------------
        // 5. BASE DE CONHECIMENTO (FAQS E ARTIGOS)
        // -------------------------------------------------------------------------
        Faq::create([
            'pergunta' => 'Como posso resetar a minha senha de rede e e-mail corporativo?',
            'resposta' => 'Para realizar o reset de senha, você pode acessar o portal de autoatendimento no endereço selfservice.empresa.com.br e utilizar sua pergunta de segurança cadastrada. Caso esteja bloqueado por tentativas incorretas, por favor abra um chamado na categoria "Acessos & Contas" ou contate o ramal 2000.',
            'categoria_id' => $catAcessos->id
        ]);

        Faq::create([
            'pergunta' => 'Como conectar ao ambiente de trabalho remotamente usando a VPN?',
            'resposta' => '1. Certifique-se de estar conectado à internet na sua residência.
2. Abra o aplicativo FortiClient VPN instalado no seu notebook corporativo.
3. Insira o endereço vpn.empresa.com.br e a porta 10443.
4. Digite seu usuário e senha de rede.
5. Confirme o código de autenticação multifator enviado ao seu Microsoft Authenticator no celular.',
            'categoria_id' => $catRedes->id
        ]);

        Faq::create([
            'pergunta' => 'Minha impressora não está imprimindo ou respondendo. O que devo verificar?',
            'resposta' => 'Primeiro, verifique se o equipamento está ligado e sem alertas de papel ou toner no painel luminoso. Verifique se o cabo de rede está conectado corretamente atrás da impressora. Caso o problema persista, localize a etiqueta de identificação com o IP impresso no painel frontal (ex: 192.168.10.25) e nos informe ao abrir o chamado para que possamos reiniciar o spooler de impressão.',
            'categoria_id' => $catHardware->id
        ]);

        Faq::create([
            'pergunta' => 'Como adicionar o e-mail corporativo no meu smartphone pessoal?',
            'resposta' => 'Instale o aplicativo oficial "Microsoft Outlook" pela Google Play Store ou App Store. Insira seu e-mail completo, clique em Entrar, digite sua senha de rede e valide a notificação no Microsoft Authenticator. Evite adicionar o e-mail pelo gerenciador padrão do celular por questões de segurança e conformidade da empresa.',
            'categoria_id' => $catSoftware->id
        ]);

        Faq::create([
            'pergunta' => 'O que fazer quando o computador ficar travado ou congelado?',
            'resposta' => 'Primeiro, tente pressionar as teclas Ctrl + Alt + Del simultaneamente para abrir o Gerenciador de Tarefas. Se não funcionar, mantenha pressionado o botão de ligar por 10 segundos para desligar forçadamente. Após reiniciar, se o problema persistir, abra um chamado na categoria Hardware.',
            'categoria_id' => $catHardware->id
        ]);

        Faq::create([
            'pergunta' => 'Como solicitar acesso a uma pasta compartilhada na rede?',
            'resposta' => 'Abra um chamado na categoria "Acessos & Contas" informando o caminho completo da pasta (ex: \\servidor\departamento\projetos) e o nome do responsável pelo departamento que autorizou o acesso. O técnico irá validar a permissão e liberar o acesso.',
            'categoria_id' => $catAcessos->id
        ]);

        Faq::create([
            'pergunta' => 'A internet está muito lenta. Como proceder?',
            'resposta' => 'Verifique se outros colegas próximos estão com o mesmo problema. Se for isolado, reinicie seu computador e o roteador (se aplicável). Teste usando um cabo de rede em vez do Wi-Fi. Se o problema persistir após essas verificações, abra um chamado na categoria Redes & Internet.',
            'categoria_id' => $catRedes->id
        ]);

        Faq::create([
            'pergunta' => 'Como fazer backup dos meus arquivos importantes?',
            'resposta' => 'A empresa possui backup automático dos arquivos salvos no servidor de rede (unidade H:). Para arquivos locais, salve sempre na pasta Documentos que é sincronizada. Não salve arquivos importantes apenas no Desktop pois não há backup automático dessa pasta.',
            'categoria_id' => $catSoftware->id
        ]);

        Artigo::create([
            'titulo' => 'Guia Completo de Acesso Remoto VPN e Boas Práticas',
            'conteudo' => '### Introdução ao Acesso Remoto
Este documento orienta os colaboradores na configuração e uso seguro do acesso remoto (VPN) aos servidores corporativos.

### Requisitos Iniciais
* Notebook corporativo configurado pela equipe de TI.
* Conexão estável com a internet.
* Celular com o aplicativo Microsoft Authenticator ativado.

### Passo a Passo de Conexão
1. Conecte seu notebook à sua rede doméstica.
2. No menu iniciar, procure por **FortiClient VPN**.
3. Insira seu usuário (ex: `juliana.financeiro`) e sua senha padrão.
4. Digite o token de 6 dígitos que aparece no aplicativo do seu celular.
5. Clique em **Connect** e aguarde o ícone do cadeado ficar verde.

### Regras de Segurança
* **Nunca** compartilhe suas credenciais de acesso VPN.
* Evite conectar-se em redes Wi-Fi públicas sem senha (cafeterias, aeroportos).
* Ao se afastar do notebook, certifique-se de bloquear a tela (Win + L).',
            'categoria_id' => $catRedes->id,
            'author_id' => $mariana->id
        ]);

        Artigo::create([
            'titulo' => 'Cartilha de Segurança da Informação e Senhas Fortes',
            'conteudo' => '### Diretrizes de Segurança Organizacional
Esta política visa proteger os dados da empresa e de nossos clientes contra acessos não autorizados.

### Política de Senhas
A partir desta data, as senhas de rede devem seguir obrigatoriamente a regra abaixo:
* Mínimo de **10 caracteres**.
* Pelo menos uma letra maiúscula e uma minúscula.
* Pelo menos um número.
* Pelo menos um caractere especial (ex: `@, #, $, &`).
* Validade máxima de **90 dias** (o sistema solicitará a troca automática).

### Como Criar uma Senha Segura e Fácil de Lembrar
Uma técnica eficaz é usar frases secretas com substituições simples:
* Frase: *Eu amo programação Laravel!*
* Senha resultante: `Eu@moPr0gL4r!`

### Incidentes e Suspeitas
Caso note qualquer comportamento estranho no seu computador (programas abrindo sozinhos, lentidão excessiva) ou receba e-mails solicitando dados pessoais (phishing), entre em contato imediato com o setor de TI.',
            'categoria_id' => $catAcessos->id,
            'author_id' => $mariana->id
        ]);

        Artigo::create([
            'titulo' => 'Procedimentos Padrão para Solicitação de Equipamentos',
            'conteudo' => '### Solicitação de Novos Equipamentos
Para solicitar um novo computador, notebook ou periférico, siga este processo:

### 1. Justificativa da Necessidade
Elabore um documento justificando a necessidade do equipamento, incluindo:
* Função do colaborador
* Softwares necessários para desempenhar a função
* Especificações técnicas mínimas requeridas
* Impacto na produtividade caso não seja aprovado

### 2. Aprovação do Gestor
O documento deve ser aprovado pelo gestor direto do solicitante.

### 3. Abertura de Chamado
Após aprovação, abra um chamado na categoria Hardware anexando:
* Documento de justificativa assinado
* Aprovação do gestor
* Orçamento (se aplicável)

### 4. Prazos
* Equipamentos de estoque: 3 dias úteis
* Equipamentos para compra: 15 a 30 dias úteis',
            'categoria_id' => $catHardware->id,
            'author_id' => $marcos->id
        ]);

        Artigo::create([
            'titulo' => 'Guia de Solução de Problemas de Rede Comuns',
            'conteudo' => '### Problema: Sem conexão à internet
**Solução:**
1. Verifique se o cabo de rede está conectado
2. Reinicie o computador
3. Teste outro dispositivo na mesma tomada
4. Verifique se o IP está configurado corretamente

### Problema: Wi-Fi instável
**Solução:**
1. Afaste-se de fontes de interferência (micro-ondas, telefones sem fio)
2. Reinicie o roteador
3. Atualize os drivers da placa de rede
4. Considere usar cabo de rede para conexões críticas

### Problema: Não consigo acessar pastas compartilhadas
**Solução:**
1. Verifique se está logado na rede corporativa
2. Confirme se tem permissão de acesso
3. Tente acessar pelo IP do servidor em vez do nome
4. Abra um chamado se o problema persistir',
            'categoria_id' => $catRedes->id,
            'author_id' => $carlos->id
        ]);

        // -------------------------------------------------------------------------
        // 6. CHAMADOS (TICKETS), COMENTÁRIOS E HISTÓRICOS
        // -------------------------------------------------------------------------

        // Ticket 1: Aberto, sem técnico
        $ticket1 = Ticket::create([
            'title' => 'Computador não liga após queda de energia no setor',
            'description' => 'Ontem no final da tarde tivemos uma breve oscilação de energia aqui no Financeiro. Ao tentar ligar o computador hoje de manhã, a CPU simplesmente não dá nenhum sinal de vida, nem os coolers ligam. Já troquei o cabo de energia e mudei de tomada mas não funcionou.',
            'status' => 'open',
            'priority' => 'high',
            'categoria_id' => $catHardware->id,
            'user_id' => $juliana->id,
            'created_at' => Carbon::now()->subDays(2),
        ]);

        TicketHistory::create([
            'ticket_id' => $ticket1->id,
            'user_id' => $juliana->id,
            'action' => 'Chamado aberto',
            'description' => 'Chamado criado pelo solicitante.',
            'created_at' => Carbon::now()->subDays(2),
        ]);

        // Ticket 2: Em andamento, técnico Carlos
        $ticket2 = Ticket::create([
            'title' => 'Instalação do pacote Office no notebook novo',
            'description' => 'Recebi meu notebook novo do RH mas notei que o Word e o Excel não estão ativados nem instalados. Preciso da suíte do Office instalada e ativada para dar andamento às planilhas de admissão dos novos colaboradores.',
            'status' => 'in_progress',
            'priority' => 'medium',
            'categoria_id' => $catSoftware->id,
            'user_id' => $leticia->id,
            'technician_id' => $carlos->id,
            'created_at' => Carbon::now()->subDays(1)->subHours(4),
        ]);

        TicketHistory::create([
            'ticket_id' => $ticket2->id,
            'user_id' => $leticia->id,
            'action' => 'Chamado aberto',
            'description' => 'Chamado criado pelo solicitante.',
            'created_at' => Carbon::now()->subDays(1)->subHours(4),
        ]);

        TicketHistory::create([
            'ticket_id' => $ticket2->id,
            'user_id' => $carlos->id,
            'action' => 'Técnico atribuído',
            'description' => 'Técnico Carlos Alberto Ferreira assumiu o atendimento.',
            'created_at' => Carbon::now()->subDays(1)->subHours(1),
        ]);

        Comentario::create([
            'ticket_id' => $ticket2->id,
            'user_id' => $leticia->id,
            'conteudo' => 'Olá! Se for possível fazer a instalação de forma remota, estou disponível a qualquer momento hoje à tarde.',
            'created_at' => Carbon::now()->subDays(1)->subHours(3),
        ]);

        Comentario::create([
            'ticket_id' => $ticket2->id,
            'user_id' => $carlos->id,
            'conteudo' => 'Olá Letícia, já assumi seu chamado. Como é um equipamento novo, preciso fazer a validação da licença localmente na sua mesa. Estou separando o instalador e passarei no seu setor dentro de 30 minutos.',
            'created_at' => Carbon::now()->subDays(1)->subHours(1),
        ]);

        Comentario::create([
            'ticket_id' => $ticket2->id,
            'user_id' => $leticia->id,
            'conteudo' => 'Excelente Carlos, estarei te aguardando. Obrigado pela agilidade!',
            'created_at' => Carbon::now()->subDays(1)->subMinutes(45),
        ]);

        TicketHistory::create([
            'ticket_id' => $ticket2->id,
            'user_id' => $carlos->id,
            'action' => 'Status atualizado',
            'description' => 'Status do chamado alterado para Em andamento.',
            'created_at' => Carbon::now()->subDays(1)->subHours(1),
        ]);

        // Ticket 3: Resolvido, técnico Carlos
        $ticket3 = Ticket::create([
            'title' => 'Sem acesso à internet via cabo na sala de reuniões A',
            'description' => 'Conectei o cabo de rede azul da mesa de reuniões no meu notebook e aparece o aviso de "Cabo desconectado ou sem sinal". Tive que fazer a apresentação via Wi-Fi, mas ela oscilou bastante. Solicito verificação da tomada de rede ou do cabo local.',
            'status' => 'resolved',
            'priority' => 'high',
            'categoria_id' => $catRedes->id,
            'user_id' => $juliana->id,
            'technician_id' => $carlos->id,
            'solution' => 'Fui até a Sala de Reuniões A e constatei que o cabo de rede azul estava com a trava quebrada, causando mau contato. Substituí por um cabo novo Cat6 de 3 metros e testei a conexão diretamente na tomada de rede da parede. Velocidade OK e sem perdas de pacotes.',
            'resolved_at' => Carbon::now()->subHours(4),
            'created_at' => Carbon::now()->subHours(10),
        ]);

        TicketHistory::create([
            'ticket_id' => $ticket3->id,
            'user_id' => $juliana->id,
            'action' => 'Chamado aberto',
            'description' => 'Chamado criado pelo solicitante.',
            'created_at' => Carbon::now()->subHours(10),
        ]);

        TicketHistory::create([
            'ticket_id' => $ticket3->id,
            'user_id' => $carlos->id,
            'action' => 'Técnico atribuído',
            'description' => 'Técnico Carlos Alberto Ferreira assumiu o atendimento do chamado.',
            'created_at' => Carbon::now()->subHours(8),
        ]);

        Comentario::create([
            'ticket_id' => $ticket3->id,
            'user_id' => $carlos->id,
            'conteudo' => 'Olá Juliana, já estou ciente do problema. Vou até a sala de reuniões A agora mesmo com um testador de cabo para verificar a integridade física do ponto.',
            'created_at' => Carbon::now()->subHours(8),
        ]);

        Comentario::create([
            'ticket_id' => $ticket3->id,
            'user_id' => $juliana->id,
            'conteudo' => 'Obrigada, Carlos. O ponto que deu problema é o que fica mais próximo do projetor de slides.',
            'created_at' => Carbon::now()->subHours(7),
        ]);

        Comentario::create([
            'ticket_id' => $ticket3->id,
            'user_id' => $carlos->id,
            'conteudo' => 'Problema resolvido! Fiz a substituição do cabo de rede da mesa de reuniões que estava com conector danificado. A internet via cabo está funcionando perfeitamente agora.',
            'created_at' => Carbon::now()->subHours(4),
        ]);

        TicketHistory::create([
            'ticket_id' => $ticket3->id,
            'user_id' => $carlos->id,
            'action' => 'Chamado resolvido',
            'description' => 'Solução registrada pelo técnico.',
            'created_at' => Carbon::now()->subHours(4),
        ]);

        // Ticket 4: Fechado, técnico Marcos
        $ticket4 = Ticket::create([
            'title' => 'Problema na assinatura do e-mail corporativo no Outlook',
            'description' => 'Minha assinatura automática sumiu do Outlook após a atualização do Office que ocorreu na semana passada. Preciso que seja restabelecido o padrão institucional da empresa, com meu nome, cargo e contatos atualizados.',
            'status' => 'closed',
            'priority' => 'low',
            'categoria_id' => $catSoftware->id,
            'user_id' => $leticia->id,
            'technician_id' => $marcos->id,
            'solution' => 'Acesse remotamente a estação de trabalho da colaboradora e recriei o arquivo de assinatura corporativa em formato HTML dentro da pasta de templates do Microsoft Outlook. Testei o envio de mensagens e a assinatura está sendo inserida de forma automática e correta.',
            'resolved_at' => Carbon::now()->subDays(2),
            'created_at' => Carbon::now()->subDays(3),
        ]);

        TicketHistory::create([
            'ticket_id' => $ticket4->id,
            'user_id' => $leticia->id,
            'action' => 'Chamado aberto',
            'description' => 'Chamado criado pelo solicitante.',
            'created_at' => Carbon::now()->subDays(3),
        ]);

        TicketHistory::create([
            'ticket_id' => $ticket4->id,
            'user_id' => $marcos->id,
            'action' => 'Técnico atribuído',
            'description' => 'Técnico Marcos Oliveira Mendes assumiu o atendimento.',
            'created_at' => Carbon::now()->subDays(2)->subHours(10),
        ]);

        Comentario::create([
            'ticket_id' => $ticket4->id,
            'user_id' => $marcos->id,
            'conteudo' => 'Olá Letícia, fiz o acesso remoto na sua máquina e reconfigurei a assinatura seguindo os padrões do manual de identidade da empresa.',
            'created_at' => Carbon::now()->subDays(2)->subHours(2),
        ]);

        Comentario::create([
            'ticket_id' => $ticket4->id,
            'user_id' => $leticia->id,
            'conteudo' => 'Perfeito, Marcos! Já testei aqui enviando um e-mail interno e a assinatura institucional apareceu certinha. Muito obrigada!',
            'created_at' => Carbon::now()->subDays(2)->subHours(1),
        ]);

        TicketHistory::create([
            'ticket_id' => $ticket4->id,
            'user_id' => $marcos->id,
            'action' => 'Chamado resolvido',
            'description' => 'Solução registrada pelo técnico.',
            'created_at' => Carbon::now()->subDays(2),
        ]);

        TicketHistory::create([
            'ticket_id' => $ticket4->id,
            'user_id' => $mariana->id,
            'action' => 'Chamado fechado',
            'description' => 'Chamado encerrado permanentemente pelo sistema/administrador.',
            'created_at' => Carbon::now()->subDays(2),
        ]);

        // Ticket 5: Crítico, aberto recentemente
        $ticket5 = Ticket::create([
            'title' => 'Sistema ERP parado - impossível acessar módulo financeiro',
            'description' => 'O sistema ERP está completamente inoperante desde as 09:00. Ninguém no setor Financeiro consegue acessar o módulo de contas a pagar. Isso está impactando diretamente o pagamento de fornecedores. Precisamos de atendimento URGENTE.',
            'status' => 'open',
            'priority' => 'critical',
            'categoria_id' => $catSoftware->id,
            'user_id' => $juliana->id,
            'created_at' => Carbon::now()->subHours(2),
        ]);

        TicketHistory::create([
            'ticket_id' => $ticket5->id,
            'user_id' => $juliana->id,
            'action' => 'Chamado aberto',
            'description' => 'Chamado crítico criado pelo solicitante.',
            'created_at' => Carbon::now()->subHours(2),
        ]);

        // Ticket 6: Baixa prioridade, em andamento
        $ticket6 = Ticket::create([
            'title' => 'Solicitação de mouse sem fio novo',
            'description' => 'Meu mouse atual está com o scroll travando às vezes. Gostaria de solicitar um mouse sem fio novo para melhorar minha produtividade.',
            'status' => 'in_progress',
            'priority' => 'low',
            'categoria_id' => $catHardware->id,
            'user_id' => $leticia->id,
            'technician_id' => $carlos->id,
            'created_at' => Carbon::now()->subDays(3),
        ]);

        TicketHistory::create([
            'ticket_id' => $ticket6->id,
            'user_id' => $leticia->id,
            'action' => 'Chamado aberto',
            'description' => 'Chamado criado pelo solicitante.',
            'created_at' => Carbon::now()->subDays(3),
        ]);

        TicketHistory::create([
            'ticket_id' => $ticket6->id,
            'user_id' => $carlos->id,
            'action' => 'Técnico atribuído',
            'description' => 'Técnico Carlos Alberto Ferreira assumiu o atendimento.',
            'created_at' => Carbon::now()->subDays(2),
        ]);

        Comentario::create([
            'ticket_id' => $ticket6->id,
            'user_id' => $carlos->id,
            'conteudo' => 'Olá Letícia, verifiquei no estoque e temos um mouse Logitech disponível. Vou passar no seu setor para entregar.',
            'created_at' => Carbon::now()->subDays(2),
        ]);

        // Ticket 7: Média prioridade, resolvido
        $ticket7 = Ticket::create([
            'title' => 'Não consigo acessar pasta compartilhada do RH',
            'description' => 'Preciso acessar a pasta \\servidor\rh\documentos para buscar um arquivo de admissão, mas aparece mensagem de acesso negado. Já verifiquei com a gestora e ela autorizou meu acesso.',
            'status' => 'resolved',
            'priority' => 'medium',
            'categoria_id' => $catAcessos->id,
            'user_id' => $leticia->id,
            'technician_id' => $marcos->id,
            'solution' => 'Adicionei o usuário Letícia ao grupo de segurança RH_Documentos no Active Directory. O acesso foi liberado e testado com sucesso. A colaboradora já consegue acessar a pasta solicitada.',
            'resolved_at' => Carbon::now()->subHours(6),
            'created_at' => Carbon::now()->subHours(12),
        ]);

        TicketHistory::create([
            'ticket_id' => $ticket7->id,
            'user_id' => $leticia->id,
            'action' => 'Chamado aberto',
            'description' => 'Chamado criado pelo solicitante.',
            'created_at' => Carbon::now()->subHours(12),
        ]);

        TicketHistory::create([
            'ticket_id' => $ticket7->id,
            'user_id' => $marcos->id,
            'action' => 'Técnico atribuído',
            'description' => 'Técnico Marcos Oliveira Mendes assumiu o atendimento.',
            'created_at' => Carbon::now()->subHours(10),
        ]);

        TicketHistory::create([
            'ticket_id' => $ticket7->id,
            'user_id' => $marcos->id,
            'action' => 'Chamado resolvido',
            'description' => 'Solução registrada pelo técnico.',
            'created_at' => Carbon::now()->subHours(6),
        ]);

        // Ticket 8: Alta prioridade, aberto
        $ticket8 = Ticket::create([
            'title' => 'Projetor da sala de reuniões B não está funcionando',
            'description' => 'O projetor da sala de reuniões B liga mas não projeta imagem. A luz está azul indicando que está ligado, mas não aparece nada na tela. Temos uma apresentação importante com cliente às 14h.',
            'status' => 'open',
            'priority' => 'high',
            'categoria_id' => $catHardware->id,
            'user_id' => $bruno->id,
            'created_at' => Carbon::now()->subMinutes(30),
        ]);

        TicketHistory::create([
            'ticket_id' => $ticket8->id,
            'user_id' => $bruno->id,
            'action' => 'Chamado aberto',
            'description' => 'Chamado criado pelo solicitante.',
            'created_at' => Carbon::now()->subMinutes(30),
        ]);
    }
}
