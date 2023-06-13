<?php

namespace App\DTO\Genre;

use Spatie\DataTransferObject\DataTransferObject;

class GenreCreateDTO extends DataTransferObject
{
    public string $title;
}
