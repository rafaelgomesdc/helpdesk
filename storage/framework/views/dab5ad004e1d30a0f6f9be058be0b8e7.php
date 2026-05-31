

<?php $__env->startSection('conteudo'); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Gerenciar Cargos</h2>
    <a href="<?php echo e(route('cargos.create')); ?>" class="btn btn-primary">+ Novo Cargo</a>
</div>

<div class="card shadow">
    <div class="card-body">
        <table class="table table-striped">
            <thead class="table-dark">
                <tr><th>Nome</th><th>Descrição</th><th>Ações</th></tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $cargos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($c->nome); ?></td>
                    <td><?php echo e($c->descricao ?? '-'); ?></td>
                    <td>
                        <a href="<?php echo e(route('cargos.edit', $c)); ?>" class="btn btn-sm btn-outline-secondary">Editar</a>
                        <form method="POST" action="<?php echo e(route('cargos.destroy', $c)); ?>" class="d-inline">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Excluir?')">Excluir</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\helpdesk\resources\views/cargos/index.blade.php ENDPATH**/ ?>