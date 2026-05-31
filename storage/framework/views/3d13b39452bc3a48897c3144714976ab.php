
<?php $__env->startSection('title', 'Painel Principal'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <h1 class="mb-4">Bem-vindo(a), <?php echo e(Session::get('usuario_nome')); ?>!</h1>

    <div class="alert alert-info">
        Perfil: <strong><?php echo e(Session::get('usuario_perfil')); ?></strong>
    </div>

    <div class="row mt-4">
        <div class="col-md-4 mb-3">
            <a href="<?php echo e(route('setores.index')); ?>" class="btn btn-primary w-100 py-3">
                Gerenciar Setores
            </a>
        </div>
        <div class="col-md-4 mb-3">
            <a href="<?php echo e(route('cargos.index')); ?>" class="btn btn-success w-100 py-3">
                Gerenciar Cargos
            </a>
        </div>
        <div class="col-md-4 mb-3">
            <a href="<?php echo e(route('usuarios.index')); ?>" class="btn btn-warning w-100 py-3">
                Gerenciar Usuários
            </a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Área de Trabalho\FATEC ADS 2026_1\6_Programação Web - Dione (5º)\trabalho_final\resources\views/dashboard.blade.php ENDPATH**/ ?>