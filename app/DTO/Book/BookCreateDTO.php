<?php

namespace App\DTO\Book;

use Spatie\DataTransferObject\DataTransferObject;

class BookCreateDTO extends DataTransferObject
{
    public string $title;
    public string $author_id;
    public string $release_date;
}
