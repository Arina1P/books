<?php

namespace App\DTO\Book;

use Spatie\DataTransferObject\DataTransferObject;

class BookReturnDTO extends DataTransferObject
{
    public ?object $returned;
}
