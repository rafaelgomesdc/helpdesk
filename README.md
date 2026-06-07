<div align="center">

<img src="assets/img/logo_sem_fundo.webp" alt="Helpdesk Logo" width="300"/>

# Helpdesk

**Sistema completo de gerenciamento de chamados e atendimento**

[![GitHub Pages](https://img.shields.io/badge/deploy-GitHub%20Pages-22C345?style=for-the-badge&logo=github)](https://seu-usuario.github.io/helpdesk)
[![License](https://img.shields.io/badge/license-MIT-22C345?style=for-the-badge)](LICENSE)
[![Status](https://img.shields.io/badge/status-em%20desenvolvimento-orange?style=for-the-badge)](#)

</div>

---

## Sobre o Projeto

O **Helpdesk** é um sistema web desenvolvido para gerenciar todo o ciclo de vida de chamados de suporte e atendimento interno ou externo. Ele permite que usuários abram solicitações, acompanhem o andamento e interajam com a equipe técnica, enquanto administradores e técnicos gerenciam, classificam e resolvem os problemas de forma organizada e eficiente.

Com controle de permissões, categorias, prioridades, dashboard e base de conhecimento, o sistema oferece tudo o que é necessário para manter um fluxo de atendimento transparente, ágil e bem estruturado.

### Funcionalidades

#### 🔐 Usuários e Autenticação
- ✅ **Banco de dados estruturado** — tabelas: `usuarios`, `setores`, `cargos` e `perfis`
- ✅ **CRUD completo** — criação, edição, listagem e exclusão de setores, cargos e usuários
- ✅ **Autenticação segura** — tela de login por e-mail e senha, além de logout
- ✅ **Sistema de Perfis** — níveis de acesso: *Administrador, Técnico e Solicitante*
- ✅ **Regras de Permissão** — controle de acesso a telas e ações conforme o perfil do usuário

#### 📩 Abertura e Comunicação
- ✅ **Abrir Chamado** — formulário com título, descrição, categoria e prioridade
- ✅ **Anexos** — possibilidade de enviar arquivos junto com o chamado
- ✅ **Listagem Pessoal** — solicitante visualiza apenas os seus próprios chamados
- ✅ **Detalhes do Chamado** — visualização completa de todas as informações
- ✅ **Comentários** — troca de mensagens entre solicitante e equipe técnica
- ✅ **Histórico de Interações** — linha do tempo com todas as ações e comentários

#### 🛠️ Gerenciamento e Painel Técnico
- ✅ **Filas de Atendimento** — listagem de chamados pendentes e em atendimento
- ✅ **Assumir Chamado** — botão "Atribuir para mim" para o técnico se responsabilizar pela solicitação
- ✅ **Controle de Status** — fluxo: *Aberto → Em andamento → Resolvido → Fechado*
- ✅ **Registro de Solução** — campo para descrição da resolução, com opção de anexo
- ✅ **Histórico de Ações** — registro detalhado de todas as alterações e horários

#### ⚙️ Categorias, Prioridades, Dashboard e Base
*(Fases de implementação)*
- ✅ **CRUD de Categorias** — ex: Hardware, Software, Rede, Acesso, etc.
- ✅ **CRUD de Prioridades** — níveis: Baixa, Média, Alta e Crítica
- ✅ **Dashboard Gerencial** — visão geral com total de chamados abertos e finalizados
- ✅ **Gráficos** — distribuição de chamados por categoria
- ✅ **Relatórios** — cálculo do tempo médio de atendimento
- ✅ **Base de Conhecimento (Opcional)**
  - ✅ CRUD de Perguntas Frequentes (FAQs)
  - ✅ CRUD de artigos técnicos com título, conteúdo e categoria

---

## Tecnologias

| Camada | Tecnologia |
|--------|-----------|
| Back-end / Linguagem | PHP 100% |
| Banco de Dados |  MySQL |
| Front-end | HTML5, CSS3, JavaScript |
| Estilização | Bootstrap e CSS] |
| Hospedagem | XAMPP, Servidor Web] |

---

## Modelo de Dados

Estrutura principal do banco de dados:

- **`usuarios`**: nome, e-mail, senha, contato, ID_setor, ID_cargo, ID_perfil
- **`setores`**: nome do setor
- **`cargos`**: nome do cargo
- **`perfis`**: tipo de perfil (Admin, Técnico, Solicitante)
- **`chamados`**: título, descrição, ID_categoria, ID_prioridade, status, ID_usuario_solicitante, ID_usuario_responsavel, data_abertura
- **`comentarios`**: ID_chamado, ID_usuario, texto, data, anexo
- **`categorias`**: nome da categoria
- **`prioridades`**: nome e nível de prioridade
- **`base_conhecimento`**: título, conteúdo, ID_categoria, tipo (FAQ ou Artigo)

---

## Como Usar

1. **Configurar o Banco de Dados**
   - Abra o phpMyAdmin (ou seu gerenciador MySQL)
   - Importe o arquivo `helpdesk.sql` disponível na raiz do projeto — ele criará automaticamente o banco `helpdesk`, todas as tabelas e os dados iniciais já cadastrados.

2. **Clonar o Repositório**
```bash
git clone https://github.com/rafaelgomesdc/helpdesk.git
cd helpdesk
```

3. **Configurar o Ambiente (.env)**
   - No Laravel, as configurações ficam no arquivo `.env` (copie o arquivo `.env.example` e renomeie para `.env`):

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=helpdesk
DB_USERNAME=root
DB_PASSWORD=
DB_CHARSET=utf8mb4
DB_COLLATION=utf8mb4_unicode_ci
```

> **Observação:** O banco já está configurado com `utf8mb4_unicode_ci` — compatível com o script SQL fornecido.
> Altere `DB_PASSWORD` se seu banco tiver senha.

4. **Executar o Sistema**
   - Certifique-se de que o servidor Apache e o MySQL estão iniciados (no XAMPP/WAMP).
   - No terminal, instale as dependências e gere a chave da aplicação:
```bash
composer install
php artisan key:generate
```
   - Para popular o sistema com dados padrão (caso não tenha importado o SQL), execute:
```bash
php artisan migrate --seed
```
   - Acesse pelo navegador:
```
http://localhost/helpdesk/public
```

> **Acesso Inicial (cadastrado no banco):**
> - **Administrador:**
>   E-mail: `admin@helpdesk.com`
>   Senha: `12345678`
>
> - **Técnico:**
>   E-mail: `tecnico@helpdesk.com`
>   Senha: `12345678`
>
> - **Usuário Solicitante:**
>   E-mail: `usuario@helpdesk.com`
>   Senha: `12345678`
>
> ⚠️ **Recomendação:** Altere essas senhas imediatamente após o primeiro acesso por questões de segurança.

---

## Modelo de Dados

Estrutura completa do banco de dados, conforme implementado:

- **`setores`**: id, nome, descrição, timestamps
- **`cargos`**: id, nome, descrição, timestamps
- **`roles` / `permissions`**: controle de perfis e permissões do sistema
- **`users`**: id, nome, e-mail, `role` (`user`, `technician`, `admin`), `profile` (`Admin`, `Técnico`, `Usuário`), status, contato, setor, cargo, senha, timestamps
- **`categorias`**: id, nome, descrição — ex: Hardware, Software, Rede, Acesso, Outros
- **`prioridades`**: id, nome, nível (1=Baixa até 4=Crítica), cor de destaque
- **`tickets`**: tabela principal de chamados — título, descrição, status (`open`, `in_progress`, `resolved`, `closed`), prioridade, categoria, solicitante, técnico responsável, solução, data de resolução
- **`ticket_histories`**: linha do tempo — registro de todas as ações e alterações
- **`ticket_attachments`**: arquivos enviados no chamado
- **`comentarios`**: troca de mensagens entre usuários e equipe
- **`faqs` e `artigos`**: base de conhecimento (opcional)

---

## Roadmap

Funcionalidades previstas para versões futuras:

### 🚀 Melhorias no Atendimento
- [ ] **Notificações por e-mail** — avisar solicitante e técnico sobre atualizações no chamado
- [ ] **Escalonamento automático** — direcionar chamados críticos para supervisores
- [ ] **Classificação de satisfação** — pesquisa de satisfação ao fechar o chamado

### 📊 Relatórios Avançados
- [ ] **Exportação de dados** — relatórios em PDF e Excel
- [ ] **Filtros personalizados** — relatórios por período, setor, técnico ou categoria
- [ ] **Gráficos de desempenho** — produtividade por técnico e setor

### 📚 Base de Conhecimento
- [ ] **Busca inteligente** — pesquisa por palavras-chave nos artigos
- [ ] **Acesso público** — parte da base pode ser visualizada sem login

---

Projeto desenvolvido para a disciplina de **Laboratório de Engenharia de Software** — FATEC Presidente Prudente, 5º termo (2026).

## 👥 Equipe / Contribuidores

- **Vitória** — [vitoriaamr](https://github.com/vitoriaamr)
- **Camila** — [milagoncc](https://github.com/milagoncc)
- **Rafael Gomes** — [rafaelgomesdc](https://github.com/rafaelgomesdc)
- **Paulo** — [Paulo5025](https://github.com/Paulo5025)

---

## Licença

Distribuído sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.
````

