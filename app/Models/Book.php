<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'books';

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'title',
        'author_id',
        'release_date',
    ];

    public function genres(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Genre::class, 'book_genre');
    }

    public function author(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->BelongsTo(Author::class);
    }

    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class)->withPivot('issued', 'returned');
    }

    /**
     * @param ?int $id
     *
     * @return string
     */

    public static function getReader(?int $id)
    {
        $book = Book::find($id);
        $user = $book?->users()?->latest('issued')?->first();
        $reader = '';
        if ($user->pivot->issued ?? '' && !$user->pivot->returned) {
            $reader = $user->name;
        }

        return $reader;
    }
}
