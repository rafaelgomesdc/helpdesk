
<?php $__env->startSection('title', 'Cargos'); ?>

<?php $__env->startSection('content'); ?>
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h1 class="h3 mb-0">Cargos</h1>
        
        <a class="btn btn-primary" href="<?php echo e(route('cargos.create')); ?>">
            <i class="bi bi-plus-circle"></i> Novo Cargo
        </a>
    </div>

    <?php if($cargos->isEmpty()): ?>
        <div class="alert alert-secondary">Nenhum cargo cadastrado.</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nome do Cargo</th>
                        <th>Descrição</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $cargos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cargo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="fw-medium"><?php echo e($cargo->nome); ?></td>
                            <td><?php echo e($cargo->descricao ?? '-'); ?></td>
                            <td class="text-end">
                                <a class="btn btn-sm btn-outline-secondary" href="<?php echo e(route('cargos.edit', $cargo)); ?>">
                                    <i class="bi bi-pencil-square"></i> Editar
                                </a>

                                <form action="<?php echo e(route('cargos.destroy', $cargo)); ?>" method="POST" class="d-inline"
                                      onsubmit="return confirm('Tem certeza que deseja excluir este cargo?');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button class="btn btn-sm btn-outline-danger" type="submit">
                                        <i class="bi bi-trash"></i> Excluir
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Área de Trabalho\FATEC ADS 2026_1\6_Programação Web - Dione (5º)\trabalho_final\resources\views/cargos/index.blade.php ENDPATH**/ ?>