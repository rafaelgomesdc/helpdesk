<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('content'); ?>

    <h2>Dashboard</h2>

    <table>
        <thead>
            <tr>
                <th>Abertos</th>
                <th>Em Andamento</th>
                <th>Finalizados</th>
                <th>Tempo Médio</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo e($totalAbertos); ?></td>
                <td><?php echo e($totalAndamento); ?></td>
                <td><?php echo e($totalFinalizados); ?></td>
                <td><?php echo e($tempoMedio); ?>h</td>
            </tr>
        </tbody>
    </table>

    <h3>Chamados por Categoria</h3>
    <table>
        <thead>
            <tr>
                <th>Categoria</th>
                <th>Total de Chamados</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $porCategoria; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($cat->nome); ?></td>
                <td><?php echo e($cat->total); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\aluno\Desktop\trabalho\helpdesk\resources\views/dashboard/index.blade.php ENDPATH**/ ?>