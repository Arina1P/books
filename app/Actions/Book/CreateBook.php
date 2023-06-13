<?php

namespace App\Actions\Book;

use App\DTO\Book\BookCreateDTO;
use App\Models\Book;

class CreateBook
{
    public function __invoke(BookCreateDTO $dto)
    {
        $data = $dto->toArray();
        $book = Book::create($data);

        foreach ($data['genres'] as $genre) {
            $book->genres()->attach($genre);
        }

        return $book->refresh();
    }
}
