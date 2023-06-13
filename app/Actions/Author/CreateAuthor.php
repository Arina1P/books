<?php

namespace App\Actions\Author;

use App\DTO\Author\AuthorCreateDTO;
use App\Models\Author;

class CreateAuthor
{
    public function __invoke(AuthorCreateDTO $dto)
    {
        $data = $dto->toArray();
        $author = Author::create($data);

        return $author->refresh();
    }
}
