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
   $request->validate([
        'user_id' => 'required|exists:users,id',
    ]);

    $user = User::findOrFail($request->user_id);

        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);


        $client = User::findOrFail($request->user_id);

        if ($client->hasBorrowed()) { // hasBorrowed() é do seu model User.php
            throw ValidationException::withMessages([
                'user_id' => 'Este usuário já possui um empréstimo ativo e não pode pegar outro livro.',
            ]);
        }
        
        if ($book->isBorrowed()) { // isBorrowed() é do seu model Book.php
            return redirect()->back()->with('error', 'Este livro já está emprestado e não pode ser emprestado novamente.');
        }

        Borrowing::create([ // O model Borrowing tem 'user_id', 'book_id', 'borrowed_at', 'returned_at' como fillable
            'user_id' => $client->id,
            'book_id' => $book->id,
            'borrowed_at' => now(),
        ]);

        return redirect()->route('books.show', $book)->with('success', 'Empréstimo registrado com sucesso.');
}

public function returnBook(Borrowing $borrowing)
{
    $borrowing->update([
        'returned_at' => now(),
    ]);

    return redirect()->route('books.show', $borrowing->book_id)->with('success', 'Devolução registrada com sucesso.');
}

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
