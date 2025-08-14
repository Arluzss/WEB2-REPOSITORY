<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Book;
use App\Models\Borrowing; 
use Illuminate\Validation\ValidationException;

class BorrowingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Book $book)
{
    $this->authorize('create', Borrowing::class);

    $request->validate(['user_id' => 'required|exists:users,id']);
    $user = User::findOrFail($request->user_id);

    // LÓGICA ALTERADA: Verifica a coluna 'debit' diretamente
    if ($user->debit > 0) {
        $formattedFine = number_format($user->debit, 2, ',', '.');
        return redirect()->back()->with('error', "Este usuário possui um débito de R$ {$formattedFine} e não pode realizar novos empréstimos.");
    }

    if ($book->isBorrowed()) { 
        return redirect()->back()->with('error', 'Este livro já está emprestado.');
    }

    if (Borrowing::hasReachedBorrowLimit($request->user_id)) {
        return redirect()->back()->with('error', 'Você já atingiu o limite de 5 livros emprestados.');
    }

    Borrowing::create([
        'user_id' => $user->id,
        'book_id' => $book->id,
        'borrowed_at' => now(),
        'due_date' => now()->addDays(15),
    ]);

    return redirect()->route('books.show', $book)->with('success', 'Empréstimo registrado com sucesso.');
}

// public function returnBook(Borrowing $borrowing)
// {
//     $borrowing->update([
//         'returned_at' => now(),
//     ]);

//     return redirect()->route('books.show', $borrowing->book_id)->with('success', 'Devolução registrada com sucesso.');
// }

public function userBorrowings(User $user)
{   
    $borrowings = $user->books()->withPivot('borrowed_at', 'returned_at')->get();

    return view('users.borrowings', compact('user', 'borrowings'));
}


    /**
     * Display the specified resource.
     */
    public function show(Book $book)
{
    // Carregando autor, editora e categoria do livro com eager loading
    $book->load(['author', 'publisher', 'category']);

    // Carregar todos os usuários para o formulário de empréstimo
    $users = User::all();

    return view('books.show', compact('book','users'));
}

public function returnBook(Borrowing $borrowing)
{
    $this->authorize('return', $borrowing);
    $fineAmount = 0;
    $returnDate = now();
    $dueDate = $borrowing->due_date; // Esta variável pode ser null

    // CORREÇÃO: Verificamos primeiro se $dueDate não é nulo.
    // O código dentro do 'if' só será executado se houver uma data de vencimento.
    if ($dueDate && $returnDate->isAfter($dueDate)) {
        
        // Esta parte do código agora está segura e só roda quando precisa.
        $overdueDays = abs($returnDate->diffInDays($dueDate));
        $fineAmount = round(($overdueDays * 0.50), 2);

        $user = User::find($borrowing->user_id);
        if ($user) {
            $user->debit += $fineAmount;
            $user->debit = round($user->debit, 2);
            $user->save();
        }
    }

    // O resto da função continua normalmente, devolvendo o livro.
    $borrowing->returned_at = $returnDate;
    $borrowing->fine_amount = $fineAmount; // Será 0 se não entrou no if
    $borrowing->save();

    $message = 'Devolução registrada com sucesso.';
    if ($fineAmount > 0) {
        $formattedFine = number_format($fineAmount, 2, ',', '.');
        $message .= " Multa de R$ {$formattedFine} adicionada ao débito do usuário.";
    }

    return redirect()->route('books.show', $borrowing->book_id)->with('success', $message);
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
