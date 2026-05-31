<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $__env->yieldContent('title', 'Sistema Chamados'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-md navbar-dark bg-primary shadow-sm">
    <div class="container">
        <a class="navbar-brand text-white" href="<?php echo e(route('dashboard')); ?>">Sistema de Chamados</a>

        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto">
                
                <?php if(session()->has('usuario_id')): ?>
                    <?php if(session('usuario_perfil') == 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="<?php echo e(route('setores.index')); ?>">Setores</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="<?php echo e(route('cargos.index')); ?>">Cargos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="<?php echo e(route('usuarios.index')); ?>">Usuários</a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>

            <ul class="navbar-nav ms-auto">
                <?php if(session()->has('usuario_id')): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown">
                            <?php echo e(session('usuario_nome')); ?>

                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <form action="<?php echo e(route('logout')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="dropdown-item text-danger">🚪 Sair do Sistema</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="<?php echo e(route('login')); ?>">Entrar</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container py-4">
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

    <?php echo $__env->yieldContent('content'); ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html><?php /**PATH C:\xampp\htdocs\trabalho_final\resources\views/layouts/app.blade.php ENDPATH**/ ?>