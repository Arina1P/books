<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'genres';

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'title',
    ];

    public function books(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->BelongsToMany(Book::class, 'book_genre');
    }
}
