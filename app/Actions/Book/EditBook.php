<?php
namespace App\Actions\Book;

use App\DTO\Book\BookCreateDTO;
use App\Models\Book;

class EditBook
{
    public function __invoke(BookCreateDTO $dto, $id)
    {
        $data = $dto->toArray();
        $book = Book::find($id);
        $book->update($data);

        $book->genres()->sync($data['genres']);

        return $book->refresh();
    }
}
