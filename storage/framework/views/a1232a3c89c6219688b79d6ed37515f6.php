

<?php $__env->startSection('conteudo'); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Gerenciar Usuários</h2>
    <a href="<?php echo e(route('users.create')); ?>" class="btn btn-primary">+ Novo Usuário</a>
</div>

<div class="card shadow">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Contato</th>
                        <th>Endereço</th>
                        <th>Perfil</th>
                        <th>Cargo</th>
                        <th>Setor</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($u->name); ?></td>
                        <td><?php echo e($u->email); ?></td>
                        <td><?php echo e($u->contato ?? '-'); ?></td>
                        <td><?php echo e($u->endereco ?? '-'); ?></td>
                        <td>
                            <?php if($u->role == 'admin'): ?> <span class="badge bg-danger">Admin</span>
                            <?php elseif($u->role == 'technician'): ?> <span class="badge bg-warning">Técnico</span>
                            <?php else: ?> <span class="badge bg-info">Usuário</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($u->cargo?->nome ?? '-'); ?></td>
                        <td><?php echo e($u->setor?->nome ?? '-'); ?></td>


                        <td>
                            <!-- Botão VER: Todos podem ver -->
                            <a href="<?php echo e(route('users.show', $u)); ?>" class="btn btn-sm btn-outline-primary">Ver</a>

                            <?php
                                // Define quem PODE EDITAR este usuário específico
                                $podeEditar = false;

                                if (session('user_role') == 'admin') {
                                    // Admin pode editar QUALQUER um
                                    $podeEditar = true;
                                } 
                                elseif ( (session('user_role') == 'technician' || session('user_role') == 'user') && session('user_id') == $u->id ) {
                                    // Técnico e Usuário só editam ELES MESMOS
                                    $podeEditar = true;
                                }
                            ?>

                            <!--  Botão EDITAR: Aparece apenas SE tiver permissão -->
                            <?php if($podeEditar): ?>
                                <a href="<?php echo e(route('users.edit', $u)); ?>" class="btn btn-sm btn-outline-secondary ms-1">Editar</a>
                            <?php endif; ?>

                            <!--  Botão EXCLUIR: Aparece APENAS para ADMIN -->
                            <?php if(session('user_role') == 'admin'): ?>
                                <form method="POST" action="<?php echo e(route('users.destroy', $u)); ?>" class="d-inline ms-1">
                                    <?php echo csrf_field(); ?> 
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</button>
                                </form>
                            <?php endif; ?>
                        </td>


                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\helpdesk\resources\views/users/index.blade.php ENDPATH**/ ?>