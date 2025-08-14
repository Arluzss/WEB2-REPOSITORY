<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'author_id', 'category_id', 'publisher_id', 'published_year', 'image'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'borrowings')
            ->using(Borrowing::class)
            ->withPivot('id', 'borrowed_at', 'returned_at', 'due_date', 'fine_amount')
            ->withTimestamps();
    }

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function isBorrowed(): bool
    {
        return $this->users()->wherePivot('returned_at', null)->exists();
    }
}
