<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'debit'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

public function books()
{
     return $this->belongsToMany(Book::class, 'borrowings')
                ->using(Borrowing::class)
                ->withPivot('id', 'borrowed_at', 'returned_at', 'due_date', 'fine_amount')
                ->withTimestamps();
}

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isBibliotecario()
    {
        return $this->role === 'bibliotecario';
    }

    public function isCliente()
    {
        return $this->role === 'cliente';
    }

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }

    public function hasBorrowed(): bool
    {
        return $this->books()->wherePivot('returned_at', null)->exists();
    }

}
