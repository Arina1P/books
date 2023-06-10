<?php

namespace App\DTO\Author;

use Spatie\DataTransferObject\DataTransferObject;

class AuthorCreateDTO extends DataTransferObject
{
    public string $name;
    public string $surname;
    public string $birth_date;
}
