<?php

namespace App\Actions\Book;

use App\DTO\Book\BookCreateDTO;
use App\Models\Book;

class CreateBook
{
    public function __invoke(BookCreateDTO $dto)
    {
        $data = $dto->toArray();
        $Book = Book::create($data);

        return $Book->refresh();
    }
}
