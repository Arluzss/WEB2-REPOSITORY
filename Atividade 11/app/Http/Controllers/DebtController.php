<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class DebtController extends Controller
{
      public function index()
    {
        $this->authorize('manageDebts', User::class);

        $usersWithDebt = User::where('debit', '>', 0)
                             ->orderBy('name')
                             ->paginate(15);

        return view('debits.index', compact('usersWithDebt'));
    }

    public function clear(User $user)
    {
        $this->authorize('manageDebts', User::class);

        $user->update(['debit' => 0.00]);

        return redirect()->route('debits.index')
                         ->with('success', "Débito de {$user->name} zerado com sucesso.");
    }
}
