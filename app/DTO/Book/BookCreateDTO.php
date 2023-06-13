<?php

namespace App\DTO\Book;

use Spatie\DataTransferObject\DataTransferObject;

class BookCreateDTO extends DataTransferObject
{
    public ?string $title;
    public ?string $author_id;
    public ?array $genres;
    public ?string $release_date;
}
