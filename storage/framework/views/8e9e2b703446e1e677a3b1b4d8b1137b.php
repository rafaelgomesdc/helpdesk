

<?php $__env->startSection('conteudo'); ?>
<h2 class="mb-3">Editar Setor</h2>

<div class="card shadow">
    <div class="card-body">
        <form method="POST" action="<?php echo e(route('setores.update', $setor)); ?>">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="mb-3">
                <label class="form-label">Nome do Setor</label>
                <input type="text" name="nome" class="form-control" value="<?php echo e(old('nome', $setor->nome)); ?>" required>
                <?php $__errorArgs = ['nome'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-danger"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="mb-3">
                <label class="form-label">Descrição</label>
                <textarea name="descricao" class="form-control" rows="4"><?php echo e(old('descricao', $setor->descricao)); ?></textarea>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                <a href="<?php echo e(route('setores.index')); ?>" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\helpdesk\resources\views/setores/edit.blade.php ENDPATH**/ ?>