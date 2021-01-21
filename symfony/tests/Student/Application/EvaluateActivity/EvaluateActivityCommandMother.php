<?php

declare(strict_types=1);

namespace BooksManagement\Tests\Book\Application\Create;

use BooksManagement\Book\Application\Create\CreateBookCommand;
use BooksManagement\Book\Domain\BookContent;
use BooksManagement\Book\Domain\BookDescription;
use BooksManagement\Book\Domain\BookTitle;
use BooksManagement\Shared\Domain\Author\AuthorUuid;
use BooksManagement\Tests\Book\Domain\BookContentMother;
use BooksManagement\Tests\Book\Domain\BookDescriptionMother;
use BooksManagement\Tests\Book\Domain\BookTitleMother;

final class CreateBookCommandMother
{
    public static function create(
        AuthorUuid $authorUuid,
        BookTitle $title,
        BookDescription $description,
        BookContent $content
    ): CreateBookCommand
    {
        return new CreateBookCommand($authorUuid->value(), $title->value(), $description->value(), $content->value());
    }

    public static function random(AuthorUuid $authorUuid): CreateBookCommand
    {
        return self::create(
            $authorUuid,
            BookTitleMother::random(),
            BookDescriptionMother::random(),
            BookContentMother::random()
        );
    }
}