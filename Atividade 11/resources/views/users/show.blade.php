@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card mb-4">
        <div class="card-header">
            <h4>Perfil de {{ $user->name }}</h4>
        </div>
        <div class="card-body">
            <p><strong>Nome:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>

            <h5>
                Débito Total de Multas:
                <span class="badge {{ $user->debit > 0 ? 'bg-danger' : 'bg-success' }}">
                    R$ {{ number_format($user->debit, 2, ',', '.') }}
                </span>
            </h5>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Histórico de Empréstimos</div>
        <div class="card-body">
            @if($user->books->isEmpty())
            <p>Este usuário não possui empréstimos registrados.</p>
            @else
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
                    @foreach($user->books as $book)
                    <tr>
                        <td>
                            <a href="{{ route('books.show', $book->id) }}">
                                {{ $book->title }}
                            </a>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($book->pivot->borrowed_at)->format('d/m/Y') }}</td>
                        <td>
                            @if($book->pivot->due_date)
                            {{ \Carbon\Carbon::parse($book->pivot->due_date)->format('d/m/Y') }}
                            @else
                            N/A
                            @endif
                        </td>
                        <td>{{ $book->pivot->returned_at ? \Carbon\Carbon::parse($book->pivot->returned_at)->format('d/m/Y') : 'Em Aberto' }}</td>
                        <td>
                            @php
                            $status = 'No prazo';
                            $colorClass = 'text-primary';
                            if ($book->pivot->returned_at) {
                            $status = 'Devolvido';
                            $colorClass = 'text-success';
                            } elseif ($book->pivot->due_date && \Carbon\Carbon::parse($book->pivot->due_date)->isPast()) {
                            $status = 'Atrasado';
                            $colorClass = 'text-danger';
                            }
                            @endphp
                            <b class="{{ $colorClass }}">{{ $status }}</b>
                        </td>
                        <td>
                            @if($book->pivot->fine_amount > 0)
                            R$ {{ number_format($book->pivot->fine_amount, 2, ',', '.') }}
                            @else
                            -
                            @endif
                        </td>
                        <td>
                            @if(is_null($book->pivot->returned_at))
                            <form action="{{ route('borrowings.return', $book->pivot->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-warning btn-sm">Devolver</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>
</div>
@endsection