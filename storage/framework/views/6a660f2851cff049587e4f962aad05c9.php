

<?php $__env->startSection('conteudo'); ?>
<h2 class="mb-3">Editar Usuário: <?php echo e($user->name); ?></h2>

<div class="card shadow">
    <div class="card-body">
        <form method="POST" action="<?php echo e(route('users.update', $user)); ?>">
            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nome Completo</label>
                    <input type="text" name="name" class="form-control" value="<?php echo e(old('name', $user->name)); ?>" required>
                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-danger"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">E-mail</label>
                    <input type="email" name="email" class="form-control" value="<?php echo e(old('email', $user->email)); ?>" required>
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-danger"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Senha <small>(deixe em branco para manter)</small></label>
                    <input type="password" name="password" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Contato</label>
                    <input type="text" name="contato" class="form-control" value="<?php echo e(old('contato', $user->contato)); ?>">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Endereço</label>
                <input type="text" name="endereco" class="form-control" value="<?php echo e(old('endereco', $user->endereco)); ?>">
            </div>

            <div class="row">
                <!-- CAMPOS ADMINISTRATIVOS: SÓ APARECE PARA ADMIN -->
                <?php if(session('user_role') == 'admin'): ?>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Perfil</label>
                    <select name="role" class="form-select" required>
                        <option value="user" <?php echo e(old('role', $user->role)=='user'?'selected':''); ?>>Usuário</option>
                        <option value="technician" <?php echo e(old('role', $user->role)=='technician'?'selected':''); ?>>Técnico</option>
                        <option value="admin" <?php echo e(old('role', $user->role)=='admin'?'selected':''); ?>>Administrador</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Cargo</label>
                    <select name="cargo_id" class="form-select" required>
                        <?php $__currentLoopData = $cargos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($c->id); ?>" <?php echo e(old('cargo_id', $user->cargo_id)==$c->id?'selected':''); ?>><?php echo e($c->nome); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Setor</label>
                    <select name="setor_id" class="form-select" required>
                        <?php $__currentLoopData = $setores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($s->id); ?>" <?php echo e(old('setor_id', $user->setor_id)==$s->id?'selected':''); ?>><?php echo e($s->nome); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <?php endif; ?>

                
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                <a href="<?php echo e(route('users.index')); ?>" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\helpdesk\resources\views/users/edit.blade.php ENDPATH**/ ?>