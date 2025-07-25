@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Lista de Livros</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('books.create.select') }}" class="btn btn-primary mb-3">
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
            @forelse($books as $book)
            <tr>
                <td>
                    {{-- O caminho correto para a imagem --}}
                    <img src="{{ asset('storage/' . $book->image) }}" alt="Capa de {{ $book->title }}" style="width: 50px; height: auto; border-radius: 4px;">
                </td>
                <td>{{ $book->title }}</td>
                <td>{{ $book->author->name }}</td>
                <td>
                    <a href="{{ route('books.show', $book->id) }}" class="btn btn-info btn-sm">
                        <i class="bi bi-eye"></i> Visualizar
                    </a>

                    <a href="{{ route('books.edit', $book->id) }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-pencil"></i> Editar
                    </a>

                    <form action="{{ route('books.destroy', $book->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Deseja excluir este livro?')">
                            <i class="bi bi-trash"></i> Deletar
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">Nenhum livro encontrado.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $books->links() }}
    </div>
</div>
@endsection