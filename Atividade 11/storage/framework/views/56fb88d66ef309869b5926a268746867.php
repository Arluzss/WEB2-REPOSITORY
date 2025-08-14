<?php $__env->startSection('content'); ?>
<div class="container">
    <h1 class="my-4">Lista de Livros</h1>

    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <a href="<?php echo e(route('books.create.select')); ?>" class="btn btn-primary mb-3">
        <i class="bi bi-plus"></i> Adicionar Livro
    </a>

    <table class="table table-striped table-hover align-middle">
        <thead>
            <tr>
                <th>Capa</th>
                <th>Título</th>
                <th>Autor</th>
                <th width="250px">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td>
                    
                    <img src="<?php echo e(asset('storage/' . $book->image)); ?>" alt="Capa de <?php echo e($book->title); ?>" style="width: 50px; height: auto; border-radius: 4px;">
                </td>
                <td><?php echo e($book->title); ?></td>
                <td><?php echo e($book->author->name); ?></td>
                <td>
                    <a href="<?php echo e(route('books.show', $book->id)); ?>" class="btn btn-info btn-sm">
                        <i class="bi bi-eye"></i> Visualizar
                    </a>

                    <a href="<?php echo e(route('books.edit', $book->id)); ?>" class="btn btn-primary btn-sm">
                        <i class="bi bi-pencil"></i> Editar
                    </a>

                    <form action="<?php echo e(route('books.destroy', $book->id)); ?>" method="POST" style="display: inline;">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Deseja excluir este livro?')">
                            <i class="bi bi-trash"></i> Deletar
                        </button>
                    </form>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="4" class="text-center">Nenhum livro encontrado.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        <?php echo e($books->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Arley\Documents\terminar\WEB2-REPOSITORY\Atividade 11\resources\views/books/index.blade.php ENDPATH**/ ?>