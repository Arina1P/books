<?php
namespace App\Actions\Author;

use App\DTO\Author\AuthorCreateDTO;
use App\Models\Author;

class EditAuthor
{
    public function __invoke(AuthorCreateDTO $dto, $id)
    {
        $data = $dto->toArray();
        $author = Author::find($id);
        $author->update($data);

        return $author->refresh();
    }
}
