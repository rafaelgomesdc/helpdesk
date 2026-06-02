
<?php $__env->startSection('title', 'Categorias'); ?>
<?php $__env->startSection('content'); ?>

<div class="page-header">
    <div>
        <h1 class="page-title">Categorias</h1>
        <p class="page-subtitle">Gerencie as categorias de chamados do sistema</p>
    </div>
    <a href="<?php echo e(route('categorias.create')); ?>" class="btn btn-primary">
        + Nova Categoria
    </a>
</div>

<div class="table-wrap">
    <div class="table-header">
        <span class="table-title"><?php echo e($categorias->count()); ?> categoria(s) cadastrada(s)</span>
    </div>

    <?php if($categorias->isEmpty()): ?>
        <div class="empty-state">
            <div class="empty-icon">🗂️</div>
            <div class="empty-text">Nenhuma categoria cadastrada ainda.</div>
        </div>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td style="font-weight:600; color:var(--text-primary);"><?php echo e($c->nome); ?></td>
                    <td><?php echo e($c->descricao ?? '—'); ?></td>
                    <td>
                        <div style="display:flex; gap:6px;">
                            <a href="<?php echo e(route('categorias.edit', $c)); ?>" class="btn btn-ghost btn-sm">
                                ✏️ Editar
                            </a>
                            <form action="<?php echo e(route('categorias.destroy', $c)); ?>" method="POST" style="display:inline">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Excluir a categoria <?php echo e($c->nome); ?>?')">
                                    🗑 Excluir
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\programação-web\helpdesk\resources\views/categorias/index.blade.php ENDPATH**/ ?>