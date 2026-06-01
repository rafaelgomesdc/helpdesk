
<?php $__env->startSection('title', 'Nova Categoria'); ?>
<?php $__env->startSection('content'); ?>

    <h2>Cadastrar Categoria</h2>
    <form action="<?php echo e(route('categorias.store')); ?>" method="POST">
        <?php echo $__env->make('categorias._form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <button type="submit">Salvar</button>
        <a class="button" href="<?php echo e(route('categorias.index')); ?>">Cancelar</a>
    </form>

<?php $__env->stopSection(); ?>@extends('layouts.app')
<?php $__env->startSection('title', 'Nova Categoria'); ?>
<?php $__env->startSection('content'); ?>

<div class="page-header">
    <div>
        <h1 class="page-title">Nova Categoria</h1>
        <p class="page-subtitle">Adicione uma nova categoria de chamados ao sistema</p>
    </div>
</div>

<div class="form-card">
    <form action="<?php echo e(route('categorias.store')); ?>" method="POST">
        <?php echo $__env->make('categorias._form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">✓ Salvar Categoria</button>
            <a href="<?php echo e(route('categorias.index')); ?>" class="btn btn-ghost">Cancelar</a>
        </div>
    </form>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\programação-web\helpdesk\resources\views/categorias/create.blade.php ENDPATH**/ ?>