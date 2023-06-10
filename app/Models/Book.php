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
    ];

    public function genres(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Genre::class, 'book_genre');
    }

    public function author(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->BelongsTo(Author::class);
    }
}
