

<?php $__env->startSection('conteudo'); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Gerenciar Setores</h2>
    <a href="<?php echo e(route('setores.create')); ?>" class="btn btn-primary">+ Novo Setor</a>
</div>

<div class="card shadow">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th width="180">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $setores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $setor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($setor->nome); ?></td>
                        <td><?php echo e($setor->descricao ?? '-'); ?></td>
                        <td>
                            <a href="<?php echo e(route('setores.edit', $setor)); ?>" class="btn btn-sm btn-outline-secondary">Editar</a>
                            <form method="POST" action="<?php echo e(route('setores.destroy', $setor)); ?>" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\helpdesk\resources\views/setores/index.blade.php ENDPATH**/ ?>