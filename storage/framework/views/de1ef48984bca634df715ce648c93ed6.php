<?php echo csrf_field(); ?>
<div class="form-group">
    <label class="form-label">Nome da Categoria</label>
    <input type="text" name="nome" class="form-input"
        placeholder="Ex: Hardware, Software, Rede..."
        value="<?php echo e(old('nome', $categoria->nome ?? '')); ?>" autofocus>
    <?php $__errorArgs = ['nome'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="form-error">⚠ <?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>
<div class="form-group">
    <label class="form-label">Descrição</label>
    <textarea name="descricao" class="form-textarea"
        placeholder="Descreva brevemente o tipo de chamados desta categoria..."><?php echo e(old('descricao', $categoria->descricao ?? '')); ?></textarea>
    <?php $__errorArgs = ['descricao'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="form-error">⚠ <?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div><?php /**PATH C:\Users\User\Desktop\programação-web\helpdesk\resources\views/categorias/_form.blade.php ENDPATH**/ ?>