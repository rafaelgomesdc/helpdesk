-- =============================================================
--  HELPDESK – Banco de Dados MySQL
--  Compatível com o projeto Laravel enviado
--  Importe este arquivo no phpMyAdmin (XAMPP)
-- =============================================================

CREATE DATABASE IF NOT EXISTS helpdesk
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE helpdesk;

-- -------------------------------------------------------------
-- 1. SETORES
-- -------------------------------------------------------------
CREATE TABLE setores (
    id         BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome       VARCHAR(100) NOT NULL,
    descricao  TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- 2. CARGOS
-- -------------------------------------------------------------
CREATE TABLE cargos (
    id         BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome       VARCHAR(100) NOT NULL,
    descricao  TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- 3b. ROLES E PERMISSÕES  (Controle de Usuários)
-- -------------------------------------------------------------
CREATE TABLE roles (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(100) NOT NULL,
    description VARCHAR(255) NULL,
    created_at  TIMESTAMP NULL,
    updated_at  TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE permissions (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(100) NOT NULL,
    description VARCHAR(255) NULL,
    created_at  TIMESTAMP NULL,
    updated_at  TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE permission_role (
    id            BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    role_id       BIGINT UNSIGNED NOT NULL,
    permission_id BIGINT UNSIGNED NOT NULL,
    created_at    TIMESTAMP NULL,
    updated_at    TIMESTAMP NULL,
    UNIQUE KEY uniq_role_permission (role_id, permission_id),
    CONSTRAINT fk_pr_role FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE,
    CONSTRAINT fk_pr_permission FOREIGN KEY (permission_id) REFERENCES permissions(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- 4. USERS  (tabela principal do Laravel Auth)
--    role: 'user' = solicitante | 'technician' = técnico | 'admin'
-- -------------------------------------------------------------
CREATE TABLE users (
    id                BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name              VARCHAR(255) NOT NULL,
    email             VARCHAR(255) NOT NULL UNIQUE,
    role              ENUM('user','technician','admin') NOT NULL DEFAULT 'user',
    status            ENUM('Pendente','Ativo','Rejeitado') NOT NULL DEFAULT 'Pendente',
    profile           ENUM('Admin','Técnico','Usuário') NOT NULL DEFAULT 'Usuário',
    phone             VARCHAR(50) NULL,
    address           VARCHAR(255) NULL,
    email_verified_at TIMESTAMP NULL,
    password          VARCHAR(255) NOT NULL,
    security_question VARCHAR(255) NULL,
    security_answer   VARCHAR(255) NULL,
    contato           VARCHAR(50) NULL,
    setor_id          BIGINT UNSIGNED NULL,
    cargo_id          BIGINT UNSIGNED NULL,
    role_id           BIGINT UNSIGNED NULL,
    remember_token    VARCHAR(100) NULL,
    created_at        TIMESTAMP NULL,
    updated_at        TIMESTAMP NULL,
    CONSTRAINT fk_users_setor FOREIGN KEY (setor_id) REFERENCES setores(id) ON DELETE SET NULL,
    CONSTRAINT fk_users_cargo FOREIGN KEY (cargo_id) REFERENCES cargos(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
-- -------------------------------------------------------------
-- 4. PASSWORD RESET TOKENS  (exigido pelo Laravel)
-- -------------------------------------------------------------
CREATE TABLE password_reset_tokens (
    email      VARCHAR(255) NOT NULL PRIMARY KEY,
    token      VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- 5. SESSIONS  (SESSION_DRIVER=database no .env)
-- -------------------------------------------------------------
CREATE TABLE sessions (
    id            VARCHAR(255) NOT NULL PRIMARY KEY,
    user_id       BIGINT UNSIGNED NULL,
    ip_address    VARCHAR(45)  NULL,
    user_agent    TEXT NULL,
    payload       LONGTEXT NOT NULL,
    last_activity INT NOT NULL,
    INDEX idx_sessions_user_id       (user_id),
    INDEX idx_sessions_last_activity (last_activity)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- 6. CACHE  (CACHE_STORE=database no .env)
-- -------------------------------------------------------------
CREATE TABLE cache (
    `key`       VARCHAR(255) NOT NULL PRIMARY KEY,
    value       MEDIUMTEXT NOT NULL,
    expiration  INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE cache_locks (
    `key`       VARCHAR(255) NOT NULL PRIMARY KEY,
    owner       VARCHAR(255) NOT NULL,
    expiration  INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- 7. JOBS / QUEUE  (QUEUE_CONNECTION=database no .env)
-- -------------------------------------------------------------
CREATE TABLE jobs (
    id           BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    queue        VARCHAR(255) NOT NULL,
    payload      LONGTEXT NOT NULL,
    attempts     TINYINT UNSIGNED NOT NULL,
    reserved_at  INT UNSIGNED NULL,
    available_at INT UNSIGNED NOT NULL,
    created_at   INT UNSIGNED NOT NULL,
    INDEX idx_jobs_queue (queue)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE job_batches (
    id             VARCHAR(255) NOT NULL PRIMARY KEY,
    name           VARCHAR(255) NOT NULL,
    total_jobs     INT NOT NULL,
    pending_jobs   INT NOT NULL,
    failed_jobs    INT NOT NULL,
    failed_job_ids LONGTEXT NOT NULL,
    options        MEDIUMTEXT NULL,
    cancelled_at   INT NULL,
    created_at     INT NOT NULL,
    finished_at    INT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE failed_jobs (
    id         BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid       VARCHAR(255) NOT NULL UNIQUE,
    connection TEXT NOT NULL,
    queue      TEXT NOT NULL,
    payload    LONGTEXT NOT NULL,
    exception  LONGTEXT NOT NULL,
    failed_at  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- 8. CATEGORIAS  (Dupla 4)
-- -------------------------------------------------------------
CREATE TABLE categorias (
    id         BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome       VARCHAR(100) NOT NULL,
    descricao  TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- 9. PRIORIDADES  (Dupla 4 – permite CRUD além do enum fixo)
-- -------------------------------------------------------------
CREATE TABLE prioridades (
    id         BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome       VARCHAR(50)  NOT NULL,          -- Ex: Baixa, Média, Alta, Crítica
    nivel      TINYINT UNSIGNED NOT NULL,       -- 1=mais baixa … 4=crítica
    cor        VARCHAR(20)  NOT NULL DEFAULT '#6c757d',  -- cor do badge
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- 10. TICKETS  (tabela central – Duplas 2 e 3)
--     Mantém compatibilidade exata com a migration do projeto
-- -------------------------------------------------------------
CREATE TABLE tickets (
    id             BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title          VARCHAR(255) NOT NULL,
    description    TEXT NOT NULL,
    status         ENUM('open','in_progress','resolved','closed') NOT NULL DEFAULT 'open',
    priority       ENUM('low','medium','high','critical') NOT NULL DEFAULT 'medium',
    categoria_id   BIGINT UNSIGNED NULL,
    user_id        BIGINT UNSIGNED NOT NULL,
    technician_id  BIGINT UNSIGNED NULL,
    solution       TEXT NULL,
    resolved_at    TIMESTAMP NULL,           -- para cálculo de tempo médio
    created_at     TIMESTAMP NULL,
    updated_at     TIMESTAMP NULL,
    CONSTRAINT fk_tickets_user       FOREIGN KEY (user_id)       REFERENCES users(id)      ON DELETE CASCADE,
    CONSTRAINT fk_tickets_technician FOREIGN KEY (technician_id) REFERENCES users(id)      ON DELETE SET NULL,
    CONSTRAINT fk_tickets_categoria  FOREIGN KEY (categoria_id)  REFERENCES categorias(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- 11. TICKET HISTORIES  (linha do tempo – Duplas 2 e 3)
-- -------------------------------------------------------------
CREATE TABLE ticket_histories (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ticket_id   BIGINT UNSIGNED NOT NULL,
    user_id     BIGINT UNSIGNED NOT NULL,
    action      VARCHAR(255) NOT NULL,
    description TEXT NULL,
    created_at  TIMESTAMP NULL,
    updated_at  TIMESTAMP NULL,
    CONSTRAINT fk_th_ticket FOREIGN KEY (ticket_id) REFERENCES tickets(id) ON DELETE CASCADE,
    CONSTRAINT fk_th_user   FOREIGN KEY (user_id)   REFERENCES users(id)   ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- 12. TICKET ATTACHMENTS  (upload de anexos – Dupla 2)
-- -------------------------------------------------------------
CREATE TABLE ticket_attachments (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ticket_id   BIGINT UNSIGNED NOT NULL,
    filename    VARCHAR(255) NOT NULL,
    path        VARCHAR(500) NOT NULL,
    size        BIGINT NULL,
    mime_type   VARCHAR(100) NULL,
    created_at  TIMESTAMP NULL,
    updated_at  TIMESTAMP NULL,
    CONSTRAINT fk_ta_ticket FOREIGN KEY (ticket_id) REFERENCES tickets(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- 13. COMENTARIOS  (comunicação no chamado – Dupla 2)
-- -------------------------------------------------------------
CREATE TABLE comentarios (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ticket_id   BIGINT UNSIGNED NOT NULL,
    user_id     BIGINT UNSIGNED NOT NULL,
    conteudo    TEXT NOT NULL,
    created_at  TIMESTAMP NULL,
    updated_at  TIMESTAMP NULL,
    CONSTRAINT fk_com_ticket FOREIGN KEY (ticket_id) REFERENCES tickets(id) ON DELETE CASCADE,
    CONSTRAINT fk_com_user   FOREIGN KEY (user_id)   REFERENCES users(id)   ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- 14. BASE DE CONHECIMENTO – FAQs  (Dupla 4 – Opcional)
-- -------------------------------------------------------------
CREATE TABLE faqs (
    id           BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    pergunta     TEXT NOT NULL,
    resposta     TEXT NOT NULL,
    categoria_id BIGINT UNSIGNED NULL,
    created_at   TIMESTAMP NULL,
    updated_at   TIMESTAMP NULL,
    CONSTRAINT fk_faq_categoria FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- 15. BASE DE CONHECIMENTO – ARTIGOS  (Dupla 4 – Opcional)
-- -------------------------------------------------------------
CREATE TABLE artigos (
    id           BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    titulo       VARCHAR(255) NOT NULL,
    conteudo     LONGTEXT NOT NULL,
    categoria_id BIGINT UNSIGNED NULL,
    author_id    BIGINT UNSIGNED NULL,
    created_at   TIMESTAMP NULL,
    updated_at   TIMESTAMP NULL,
    CONSTRAINT fk_art_categoria FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE SET NULL,
    CONSTRAINT fk_art_author    FOREIGN KEY (author_id)    REFERENCES users(id)      ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================================
--  DADOS INICIAIS (Seeds)
-- =============================================================

-- Setores
INSERT INTO setores (nome, descricao, created_at, updated_at) VALUES
('TI',         'Tecnologia da Informação',       NOW(), NOW()),
('RH',         'Recursos Humanos',               NOW(), NOW()),
('Financeiro', 'Setor Financeiro',               NOW(), NOW()),
('Operações',  'Operações e Logística',          NOW(), NOW());

-- Cargos
INSERT INTO cargos (nome, descricao, created_at, updated_at) VALUES
('Analista',          'Analista de sistemas / processos', NOW(), NOW()),
('Técnico',           'Técnico de suporte',               NOW(), NOW()),
('Gerente',           'Gerência de área',                 NOW(), NOW()),
('Desenvolvedor',     'Desenvolvedor de software',        NOW(), NOW()),
('Administrador',     'Administrador do sistema',         NOW(), NOW());

-- Categorias
INSERT INTO categorias (nome, descricao, created_at, updated_at) VALUES
('Hardware',   'Problemas com equipamentos físicos', NOW(), NOW()),
('Software',   'Erros em programas e sistemas',      NOW(), NOW()),
('Rede',       'Conectividade e infraestrutura',     NOW(), NOW()),
('Acesso',     'Senhas, permissões e acessos',       NOW(), NOW()),
('Outros',     'Demais solicitações',                NOW(), NOW());

-- Prioridades
INSERT INTO prioridades (nome, nivel, cor, created_at, updated_at) VALUES
('Baixa',    1, '#28a745', NOW(), NOW()),
('Média',    2, '#ffc107', NOW(), NOW()),
('Alta',     3, '#fd7e14', NOW(), NOW()),
('Crítica',  4, '#dc3545', NOW(), NOW());

-- Usuários de exemplo
-- Senha do admin: 12345678 (rodar php artisan helpdesk:setup após importar)
INSERT INTO users (name, email, role, status, profile, phone, address, password, security_question, security_answer, contato, setor_id, cargo_id, role_id, created_at, updated_at) VALUES
('Administrador', 'admin@helpdesk.com', 'admin', 'Ativo', 'Admin', '(11) 99999-0001', 'Presidente Prudente/SP', '$2y$12$wKLUX7b6mxX8m2FzOVtMDO7FtYfQlt9dNXs7b4alvldh1uM1/71H.', 'Qual o nome da sua primeira escola?', NULL, '(11) 99999-0001', 1, 5, NULL, NOW(), NOW()),
('Carlos Técnico', 'tecnico@helpdesk.com', 'technician', 'Ativo', 'Técnico', '(11) 99999-0002', 'Presidente Prudente/SP', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '(11) 99999-0002', 1, 2, NULL, NOW(), NOW()),
('Maria Usuária', 'usuario@helpdesk.com', 'user', 'Ativo', 'Usuário', '(11) 99999-0003', 'Presidente Prudente/SP', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '(11) 99999-0003', 2, 1, NULL, NOW(), NOW());


-- Chamado de exemplo
INSERT INTO tickets (title, description, status, priority, categoria_id, user_id, technician_id, created_at, updated_at) VALUES
('Computador não liga', 'O computador da recepção não está ligando desde hoje cedo.', 'open', 'high', 1, 3, NULL, NOW(), NOW());

-- Histórico do chamado de exemplo
INSERT INTO ticket_histories (ticket_id, user_id, action, description, created_at, updated_at) VALUES
(1, 3, 'Chamado aberto', 'Solicitante abriu o chamado.', NOW(), NOW());
