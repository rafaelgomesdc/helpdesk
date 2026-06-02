<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?php echo $__env->yieldContent('title', 'Help Desk'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; max-width: 900px }
        header, footer { margin: 10px 0 }
        .flash { padding:10px; border:1px solid #cfc; background:#efe }
        .erro { color:#b00; font-size: 0.95rem }
        form > div { margin-bottom:10px }
        table { width:100%; border-collapse: collapse }
        th, td { border:1px solid #ddd; padding:8px }
        th { text-align:left; background:#f7f7f7 }
        a.button, button { display:inline-block; padding:8px 12px; border:1px solid #ccc; background:#eee; text-decoration:none }
    </style>
</head>
<body>
    <header>
        <h1>Help Desk</h1>
        <nav>
            <a href="<?php echo e(route('dashboard')); ?>">Dashboard</a> |
            <a href="<?php echo e(route('categorias.index')); ?>">Categorias</a>
        </nav>
    </header>

    <?php if(session('sucesso')): ?>
        <div class="flash"><?php echo e(session('sucesso')); ?></div>
    <?php endif; ?>

    <?php echo $__env->yieldContent('content'); ?>

    <footer>
        <small>Fatec Prudente – Programação Web (Laravel)</small>
    </footer>
</body>
</html>
<?php /**PATH C:\Users\aluno\Desktop\trabalho\helpdesk\resources\views/layouts/app.blade.php ENDPATH**/ ?>