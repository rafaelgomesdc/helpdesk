<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help Desk - Sistema de Chamados</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Menu de Navegação -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
    <div class="container">
        <a class="navbar-brand" href="<?php echo e(route('users.index')); ?>">Help Desk</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto">
                
                <!-- APARECE APENAS SE FOR ADMIN OU TÉCNICO -->
                <?php if(session('user_role') == 'admin' || session('user_role') == 'technician'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('users.index')); ?>">Usuários</a>
                    </li>
                <?php endif; ?>

                
                <?php if(session('user_role') == 'user'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('users.show', session('user_id'))); ?>">Meu Perfil</a>
                    </li>
                <?php endif; ?>

                
                <?php if(session('user_role') == 'admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('cargos.index')); ?>">Cargos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('setores.index')); ?>">Setores</a>
                    </li>
                <?php endif; ?>
            </ul>

                
            <ul class="navbar-nav">
                <li class="nav-item">
                    <span class="nav-link text-white">Olá, <?php echo e(session('user_name')); ?></span>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="<?php echo e(route('logout')); ?>" onclick="return confirm('Sair do sistema?')">Sair</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

    <!-- Conteúdo Principal -->
    <div class="container">
        <!-- Mensagens de Sucesso / Erro -->
        <?php if(session('sucesso')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo e(session('sucesso')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if(session('erro')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo e(session('erro')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- O conteúdo de cada tela vai aparecer aqui -->
        <?php echo $__env->yieldContent('conteudo'); ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html><?php /**PATH C:\xampp\htdocs\helpdesk\resources\views/layouts/app.blade.php ENDPATH**/ ?>