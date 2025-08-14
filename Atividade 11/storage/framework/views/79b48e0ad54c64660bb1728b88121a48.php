<?php if(auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isBibliotecario())): ?>
<div class="card mb-4">
    <div class="card-header">Registrar Empréstimo</div>
    <div class="card-body">
        <form action="<?php echo e(route('books.borrow', $book)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="mb-3">
                <label for="user_id" class="form-label">Usuário</label>
                <select class="form-select" id="user_id" name="user_id" required>
                    <option value="" selected>Selecione um usuário</option>
                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Registrar Empréstimo</button>
        </form>
    </div>
</div>
<?php endif; ?>

<div class="card">
    <div class="card-header">Histórico de Empréstimos</div>
    <div class="card-body">
        <?php if($book->users->isEmpty()): ?>
            <p>Nenhum empréstimo registrado.</p>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Usuário</th>
                        <th>Data de Empréstimo</th>
                        <th>Prazo Final</th>
                        <th>Data de Devolução</th>
                        <th>Status</th>
                        <th>Multa</th> <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $book->users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <a href="<?php echo e(route('users.show', $user->id)); ?>">
                                    <?php echo e($user->name); ?>

                                </a>
                            </td>
                            <td><?php echo e(\Carbon\Carbon::parse($user->pivot->borrowed_at)->format('d/m/Y')); ?></td>
                            <td>
                                <?php if($user->pivot->due_date): ?>
                                    <?php echo e(\Carbon\Carbon::parse($user->pivot->due_date)->format('d/m/Y')); ?>

                                <?php else: ?>
                                    N/A
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($user->pivot->returned_at ? \Carbon\Carbon::parse($user->pivot->returned_at)->format('d/m/Y') : 'Em Aberto'); ?></td>
                            <td>
                                <?php
                                    $status = 'No prazo';
                                    $colorClass = 'text-primary';
                                    if ($user->pivot->returned_at) {
                                        $status = 'Devolvido';
                                        $colorClass = 'text-success';
                                    } elseif ($user->pivot->due_date && \Carbon\Carbon::parse($user->pivot->due_date)->isPast()) {
                                        $status = 'Atrasado';
                                        $colorClass = 'text-danger';
                                    }
                                ?>
                                <b class="<?php echo e($colorClass); ?>"><?php echo e($status); ?></b>
                            </td>
                            
                            <td>
                                <?php if($user->pivot->fine_amount > 0): ?>
                                    R$ <?php echo e(number_format($user->pivot->fine_amount, 2, ',', '.')); ?>

                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php if(is_null($user->pivot->returned_at)): ?>
                                    <form action="<?php echo e(route('borrowings.return', $user->pivot->id)); ?>" method="POST">
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
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Arley\Documents\terminar\WEB2-REPOSITORY\Atividade 11\resources\views/books/show.blade.php ENDPATH**/ ?>