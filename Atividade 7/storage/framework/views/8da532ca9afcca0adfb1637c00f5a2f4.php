

<?php $__env->startSection('content'); ?>
<div class="container">
    <h1 class="my-4">Lista de Livros</h1>

    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <a href="<?php echo e(route('books.create.id')); ?>" class="btn btn-success mb-3">
        <i class="bi bi-plus"></i> Adicionar Livro (Com ID)
    </a>
    <a href="<?php echo e(route('books.create.select')); ?>" class="btn btn-primary mb-3">
        <i class="bi bi-plus"></i> Adicionar Livro (Com Select)
    </a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Autor</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($book->id); ?></td>
                    <td><?php echo e($book->title); ?></td>
                    <td><?php echo e($book->author->name); ?></td>
                    <td>
                        <!-- Botão de Visualizar -->
                        <a href="<?php echo e(route('books.show', $book->id)); ?>" class="btn btn-info btn-sm">
                            <i class="bi bi-eye"></i> Visualizar
                        </a>

                        <!-- Botão de Editar -->
                        <a href="<?php echo e(route('books.edit', $book->id)); ?>" class="btn btn-primary btn-sm">
                            <i class="bi bi-pencil"></i> Editar
                        </a>

                        <!-- Botão de Deletar -->
                        <form action="<?php echo e(route('books.destroy', $book->id)); ?>" method="POST" style="display: inline;">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Deseja excluir este livro?')">
                                <i class="bi bi-trash"></i> Deletar
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="4">Nenhum livro encontrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Controles de Paginação -->
    <div class="d-flex justify-content-center">
        <?php echo e($books->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>
<div class="container">
    <h1 class="my-4">Lista de Livros</h1>

    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <a href="<?php echo e(route('books.create.id')); ?>" class="btn btn-success mb-3">
        <i class="bi bi-plus"></i> Adicionar Livro (Com ID)
    </a>
    <a href="<?php echo e(route('books.create.select')); ?>" class="btn btn-primary mb-3">
        <i class="bi bi-plus"></i> Adicionar Livro (Com Select)
    </a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Autor</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($book->id); ?></td>
                    <td><?php echo e($book->title); ?></td>
                    <td><?php echo e($book->author->name); ?></td>
                    <td>
                        <!-- Botão de Visualizar -->
                        <a href="<?php echo e(route('books.show', $book->id)); ?>" class="btn btn-info btn-sm">
                            <i class="bi bi-eye"></i> Visualizar
                        </a>

                        <!-- Botão de Editar -->
                        <a href="<?php echo e(route('books.edit', $book->id)); ?>" class="btn btn-primary btn-sm">
                            <i class="bi bi-pencil"></i> Editar
                        </a>

                        <!-- Botão de Deletar -->
                        <form action="<?php echo e(route('books.destroy', $book->id)); ?>" method="POST" style="display: inline;">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Deseja excluir este livro?')">
                                <i class="bi bi-trash"></i> Deletar
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="4">Nenhum livro encontrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Controles de Paginação -->
    <div class="d-flex justify-content-center">
        <?php echo e($books->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Arley\Documents\terminar\WEB2-REPOSITORY\Atividade 6.1\resources\views/books/index.blade.php ENDPATH**/ ?>