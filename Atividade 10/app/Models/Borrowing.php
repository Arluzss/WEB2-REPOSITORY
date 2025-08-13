<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'book_id', 'borrowed_at', 'returned_at'];

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
}
