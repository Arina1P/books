<?php

namespace App\Actions\Book;

use App\DTO\Book\BookReturnDTO;
use App\Models\Book;

class ReturnBook
{
    public function __invoke(BookReturnDTO $dto, int $id)
    {
        $book = Book::find($id);
        $data = $dto->toArray();
        $userId = $book->users()->latest('issued')->first()->id;
        $book->users()->updateExistingPivot($userId, $data);

        return $book->id;
    }
}
