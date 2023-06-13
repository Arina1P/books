<?php

namespace App\Actions\Book;


use App\DTO\Book\BookIssueDTO;
use App\Models\Book;

class IssueBook
{
    public function __invoke(BookIssueDTO $dto, $bookId)
    {
        $book = Book::find($bookId);
        $data = $dto->toArray();
        $book->users()->attach($data['user_id'], $data);

        return $book->id;
    }
}
