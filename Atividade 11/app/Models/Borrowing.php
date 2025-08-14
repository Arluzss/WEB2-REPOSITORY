<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Borrowing extends Pivot
{
    use HasFactory;
    protected $fillable = ['user_id', 'book_id', 'borrowed_at', 'returned_at', 'due_date', 'fine_amount'];
protected $table = 'borrowings';
    protected $casts = [
        'borrowed_at' => 'datetime',
        'returned_at' => 'datetime',
        'due_date'    => 'datetime', // Adicione esta linha
    ];
    // Relacionamento com User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relacionamento com Book
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }

    public static function hasReachedBorrowLimit($userId)
    {
        return self::where('user_id', $userId)->whereNull('returned_at')->count() >= 5;
    }

    public function status(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->returned_at) {
                    return 'Devolvido';
                }

                if ($this->due_date->isPast()) {
                    return 'Atrasado';
                }

                return 'No prazo';
            }
        );
    }
}
