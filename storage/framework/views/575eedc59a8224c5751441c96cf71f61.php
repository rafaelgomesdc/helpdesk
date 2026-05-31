
<?php $__env->startSection('title', 'Login - Sistema Chamados'); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card mt-5">
            <div class="card-header text-center">
                <h4>Acesso ao Sistema</h4>
            </div>
            <div class="card-body">
                
                
                <?php if(session('erro')): ?>
                    <div class="alert alert-danger">
                        <?php echo e(session('erro')); ?>

                    </div>
                <?php endif; ?>

                
                <form method="POST" action="<?php echo e(route('autenticar')); ?>">
                    <?php echo csrf_field(); ?>

                    <div class="mb-3">
                        <label class="form-label">E-mail</label>
                        <input type="email" name="email" class="form-control" required value="<?php echo e(old('email')); ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Senha</label>
                        <input type="password" name="senha" class="form-control" required>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Entrar</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\trabalho_final\resources\views/auth/login.blade.php ENDPATH**/ ?>