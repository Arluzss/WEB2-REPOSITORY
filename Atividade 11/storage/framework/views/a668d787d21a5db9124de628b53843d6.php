<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="card mb-4">
        <div class="card-header">
            <h4>Perfil de <?php echo e($user->name); ?></h4>
        </div>
        <div class="card-body">
            <p><strong>Nome:</strong> <?php echo e($user->name); ?></p>
            <p><strong>Email:</strong> <?php echo e($user->email); ?></p>

            <h5>
                Débito Total de Multas:
                <span class="badge <?php echo e($user->debit > 0 ? 'bg-danger' : 'bg-success'); ?>">
                    R$ <?php echo e(number_format($user->debit, 2, ',', '.')); ?>

                </span>
            </h5>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Histórico de Empréstimos</div>
        <div class="card-body">
            <?php if($user->books->isEmpty()): ?>
            <p>Este usuário não possui empréstimos registrados.</p>
            <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Livro</th>
                        <th>Emprestado em</th>
                        <th>Prazo Final</th>
                        <th>Devolvido em</th>
                        <th>Status</th>
                        <th>Multa</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $user->books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                            <a href="<?php echo e(route('books.show', $book->id)); ?>">
                                <?php echo e($book->title); ?>

                            </a>
                        </td>
                        <td><?php echo e(\Carbon\Carbon::parse($book->pivot->borrowed_at)->format('d/m/Y')); ?></td>
                        <td>
                            <?php if($book->pivot->due_date): ?>
                            <?php echo e(\Carbon\Carbon::parse($book->pivot->due_date)->format('d/m/Y')); ?>

                            <?php else: ?>
                            N/A
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($book->pivot->returned_at ? \Carbon\Carbon::parse($book->pivot->returned_at)->format('d/m/Y') : 'Em Aberto'); ?></td>
                        <td>
                            <?php
                            $status = 'No prazo';
                            $colorClass = 'text-primary';
                            if ($book->pivot->returned_at) {
                            $status = 'Devolvido';
                            $colorClass = 'text-success';
                            } elseif ($book->pivot->due_date && \Carbon\Carbon::parse($book->pivot->due_date)->isPast()) {
                            $status = 'Atrasado';
                            $colorClass = 'text-danger';
                            }
                            ?>
                            <b class="<?php echo e($colorClass); ?>"><?php echo e($status); ?></b>
                        </td>
                        <td>
                            <?php if($book->pivot->fine_amount > 0): ?>
                            R$ <?php echo e(number_format($book->pivot->fine_amount, 2, ',', '.')); ?>

                            <?php else: ?>
                            -
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if(is_null($book->pivot->returned_at)): ?>
                            <form action="<?php echo e(route('borrowings.return', $book->pivot->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>
                                <button class="btn btn-warning btn-sm">Devolver</button>
                            </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Arley\Documents\terminar\WEB2-REPOSITORY\Atividade 11\resources\views/users/show.blade.php ENDPATH**/ ?>