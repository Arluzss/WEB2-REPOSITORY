@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Gestão de Débitos</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            Usuários com Débitos Pendentes
        </div>
        <div class="card-body">
            @if($usersWithDebt->isEmpty())
                <p class="text-center">Nenhum usuário com débito encontrado.</p>
            @else
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
                        @foreach($usersWithDebt as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td><strong>R$ {{ number_format($user->debit, 2, ',', '.') }}</strong></td>
                                <td class="text-end">
                                    <form action="{{ route('debits.clear', $user) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja zerar o débito de {{ $user->name }}? Esta ação não pode ser desfeita.');">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success btn-sm">
                                            Zerar Débito
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $usersWithDebt->links() }}
    </div>
</div>
@endsection