<?php

namespace App\Actions\Genre;

use App\DTO\Genre\GenreCreateDTO;
use App\Models\Genre;

class CreateGenre
{
    public function __invoke(GenreCreateDTO $dto)
    {
        $data = $dto->toArray();
        $genre = Genre::create($data);

        return $genre->refresh();
    }
}
