<?php
namespace App\Actions\Genre;

use App\DTO\Genre\GenreCreateDTO;
use App\Models\Genre;

class EditGenre
{
    public function __invoke(GenreCreateDTO $dto, $id)
    {
        $data = $dto->toArray();
        $genre = Genre::find($id);
        $genre->update($data);

        return $genre->refresh();
    }
}
