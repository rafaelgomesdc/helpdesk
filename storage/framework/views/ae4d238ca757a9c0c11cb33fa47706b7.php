
<?php $__env->startSection('title', 'Novo Chamado'); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">Cadastrar Chamado</div>
                <div class="card-body">
                    <form action="<?php echo e(route('chamados.store')); ?>" method="POST" class="vstack gap-3">
                        <?php echo $__env->make('chamados._form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Salvar
                            </button>
                            <a class="btn btn-outline-secondary" href="<?php echo e(route('chamados.index')); ?>">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Área de Trabalho\FATEC ADS 2026_1\6_Programação Web - Dione (5º)\trabalho_final\resources\views/setores/create.blade.php ENDPATH**/ ?>