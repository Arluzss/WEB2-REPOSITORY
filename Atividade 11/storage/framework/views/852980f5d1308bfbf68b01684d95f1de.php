

<?php $__env->startSection('content'); ?>
<div class="container">
    <h1 class="my-4">Gestão de Débitos</h1>

    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header">
            Usuários com Débitos Pendentes
        </div>
        <div class="card-body">
            <?php if($usersWithDebt->isEmpty()): ?>
                <p class="text-center">Nenhum usuário com débito encontrado.</p>
            <?php else: ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Valor do Débito</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $usersWithDebt; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($user->id); ?></td>
                                <td><?php echo e($user->name); ?></td>
                                <td><?php echo e($user->email); ?></td>
                                <td><strong>R$ <?php echo e(number_format($user->debit, 2, ',', '.')); ?></strong></td>
                                <td class="text-end">
                                    <form action="<?php echo e(route('debits.clear', $user)); ?>" method="POST" onsubmit="return confirm('Tem certeza que deseja zerar o débito de <?php echo e($user->name); ?>? Esta ação não pode ser desfeita.');">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>
                                        <button type="submit" class="btn btn-success btn-sm">
                                            Zerar Débito
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        <?php echo e($usersWithDebt->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Arley\Documents\terminar\WEB2-REPOSITORY\Atividade 11\resources\views/debits/index.blade.php ENDPATH**/ ?>