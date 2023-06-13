<?php

namespace App\DTO\Book;

use Spatie\DataTransferObject\DataTransferObject;

class BookIssueDTO extends DataTransferObject
{
    public ?string $user_id;
    public ?object $issued;
}
