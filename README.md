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
   - Execute o script SQL disponível na pasta `database/` para criar as tabelas e relações.

2. **Clonar o Repositório**
```bash
git clone https://github.com/seu-usuario/helpdesk.git
cd helpdesk

3. **Configurar a Conexão**

Edite o arquivo de configuração da conexão com o banco de dados, localizado em `config/database.php`, inserindo as credenciais do seu ambiente:

```php
<?php
// Configurações de acesso ao Banco de Dados
define('DB_HOST', 'localhost');     // Servidor do banco (geralmente localhost)
define('DB_NAME', 'helpdesk');      // Nome do banco de dados criado
define('DB_USER', 'root');          // Usuário do banco (padrão: root)

```markdown

> **Observação:** Se estiver utilizando um servidor de hospedagem, altere os valores conforme os dados fornecidos pelo provedor.

---

4. **Executar o Sistema**

Após configurar a conexão, siga os passos para rodar o sistema:

1. Certifique-se de que o servidor Apache e o MySQL estão iniciados (no XAMPP/WAMP).
2. Coloque a pasta do projeto dentro do diretório de hospedagem (`htdocs` no XAMPP).
3. Acesse pelo navegador:
```
http://localhost/helpdesk
```

> **Acesso Inicial:**
> O sistema já vem com um usuário administrador padrão para o primeiro acesso:
> - **E-mail:** `admin@helpdesk.com`
> - **Senha:** `admin123`
>
> ⚠️ **Recomendação:** Altere essa senha imediatamente após o primeiro login por questões de segurança.

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
```
define('DB_PASS', '');              // Senha do banco (em branco por padrão no XAMPP)
define('DB_CHARSET', 'utf8mb4');    // Codificação de caracteres
