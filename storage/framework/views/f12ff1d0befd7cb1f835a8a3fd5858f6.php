

<?php $__env->startSection('conteudo'); ?>
<h2 class="mb-3">Detalhes do Usuário</h2>

<div class="card shadow">
    <div class="card-body">
        <table class="table table-borderless">
            <tr><th>Nome:</th><td><?php echo e($user->name); ?></td></tr>
            <tr><th>E-mail:</th><td><?php echo e($user->email); ?></td></tr>
            <tr><th>Contato:</th><td><?php echo e($user->contato ?? 'Não informado'); ?></td></tr>
            <tr><th>Endereço:</th><td><?php echo e($user->endereco ?? 'Não informado'); ?></td></tr>
            <tr><th>Perfil:</th><td>
                <?php if($user->role == 'admin'): ?> Administrador
                <?php elseif($user->role == 'technician'): ?> Técnico
                <?php else: ?> Usuário <?php endif; ?>
            </td></tr>
            <tr><th>Cargo:</th><td><?php echo e($user->cargo?->nome ?? '-'); ?></td></tr>
            <tr><th>Setor:</th><td><?php echo e($user->setor?->nome ?? '-'); ?></td></tr>
            <tr><th>Cadastrado em:</th><td><?php echo e($user->created_at->format('d/m/Y H:i')); ?></td></tr>
        </table>

        <div class="mt-4">
            <?php
                $podeEditar = false;
                if (session('user_role') == 'admin' || session('user_id') == $user->id) {
                    $podeEditar = true;
                }
            ?>

            <?php if($podeEditar): ?>
                <a href="<?php echo e(route('users.edit', $user)); ?>" class="btn btn-primary">Editar Meus Dados</a>
            <?php endif; ?>

            <a href="<?php echo e(route('users.index')); ?>" class="btn btn-secondary ms-2">
                Voltar
            </a>
        </div>
        

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\helpdesk\resources\views/users/show.blade.php ENDPATH**/ ?>