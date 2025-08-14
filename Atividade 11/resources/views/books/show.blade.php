@extends('layouts.app')

@if(auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isBibliotecario()))
<div class="card mb-4">
    <div class="card-header">Registrar Empréstimo</div>
    <div class="card-body">
        <form action="{{ route('books.borrow', $book) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="user_id" class="form-label">Usuário</label>
                <select class="form-select" id="user_id" name="user_id" required>
                    <option value="" selected>Selecione um usuário</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-success">Registrar Empréstimo</button>
        </form>
    </div>
</div>
@endif

<div class="card">
    <div class="card-header">Histórico de Empréstimos</div>
    <div class="card-body">
        @if($book->users->isEmpty())
            <p>Nenhum empréstimo registrado.</p>
        @else
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
                    @foreach($book->users as $user)
                        <tr>
                            <td>
                                <a href="{{ route('users.show', $user->id) }}">
                                    {{ $user->name }}
                                </a>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($user->pivot->borrowed_at)->format('d/m/Y') }}</td>
                            <td>
                                @if($user->pivot->due_date)
                                    {{ \Carbon\Carbon::parse($user->pivot->due_date)->format('d/m/Y') }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>{{ $user->pivot->returned_at ? \Carbon\Carbon::parse($user->pivot->returned_at)->format('d/m/Y') : 'Em Aberto' }}</td>
                            <td>
                                @php
                                    $status = 'No prazo';
                                    $colorClass = 'text-primary';
                                    if ($user->pivot->returned_at) {
                                        $status = 'Devolvido';
                                        $colorClass = 'text-success';
                                    } elseif ($user->pivot->due_date && \Carbon\Carbon::parse($user->pivot->due_date)->isPast()) {
                                        $status = 'Atrasado';
                                        $colorClass = 'text-danger';
                                    }
                                @endphp
                                <b class="{{ $colorClass }}">{{ $status }}</b>
                            </td>
                            
                            <td>
                                @if($user->pivot->fine_amount > 0)
                                    R$ {{ number_format($user->pivot->fine_amount, 2, ',', '.') }}
                                @else
                                    -
                                @endif
                            </td>

                            <td>
                                @if(is_null($user->pivot->returned_at))
                                    <form action="{{ route('borrowings.return', $user->pivot->id) }}" method="POST">
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