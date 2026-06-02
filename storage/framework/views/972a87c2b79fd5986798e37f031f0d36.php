
<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('content'); ?>

<div class="page-header">
    <div>
        <h1 class="page-title">Dashboard</h1>
        <p class="page-subtitle">Visão geral dos chamados em tempo real</p>
    </div>
</div>


<div class="stats-grid">
    <div class="stat-card blue">
        <div class="stat-label">Abertos</div>
        <div class="stat-value blue"><?php echo e($totalAbertos); ?></div>
        <div class="stat-footer">Aguardando atendimento</div>
    </div>
    <div class="stat-card amber">
        <div class="stat-label">Em Andamento</div>
        <div class="stat-value amber"><?php echo e($totalAndamento); ?></div>
        <div class="stat-footer">Em tratamento técnico</div>
    </div>
    <div class="stat-card green">
        <div class="stat-label">Finalizados</div>
        <div class="stat-value green"><?php echo e($totalFinalizados); ?></div>
        <div class="stat-footer">Chamados encerrados</div>
    </div>
    <div class="stat-card rose">
        <div class="stat-label">Tempo Médio</div>
        <div class="stat-value rose"><?php echo e($tempoMedio); ?>h</div>
        <div class="stat-footer">Média de resolução</div>
    </div>
</div>


<div class="table-wrap">
    <div class="table-header">
        <span class="table-title">Chamados por Categoria</span>
        <a href="<?php echo e(route('categorias.index')); ?>" class="btn btn-ghost btn-sm">
            Gerenciar Categorias →
        </a>
    </div>

    <?php $total = $porCategoria->sum('total') ?: 1; ?>

    <div style="padding: 20px;">
        <?php $__empty_1 = true; $__currentLoopData = $porCategoria; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="progress-wrap">
                <div class="progress-top">
                    <span class="progress-name"><?php echo e($cat->nome); ?></span>
                    <span class="progress-count"><?php echo e($cat->total); ?> chamado<?php echo e($cat->total != 1 ? 's' : ''); ?></span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: <?php echo e(($cat->total / $total) * 100); ?>%"></div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="empty-state">
                <div class="empty-icon">📭</div>
                <div class="empty-text">Nenhum chamado registrado ainda</div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\programação-web\helpdesk\resources\views/dashboard/index.blade.php ENDPATH**/ ?>