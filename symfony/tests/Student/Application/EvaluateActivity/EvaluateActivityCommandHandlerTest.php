<?php

declare(strict_types=1);

namespace BooksManagement\Tests\Book\Application\Create;

use BooksManagement\Book\Application\Create\BookCreator;
use BooksManagement\Book\Application\Create\CreateBookHandler;
use BooksManagement\Tests\Author\Domain\AuthorMother;
use BooksManagement\Tests\Mocks\Author\AuthorRepositoryMock;
use BooksManagement\Tests\Book\Domain\BookMother;
use BooksManagement\Tests\Mocks\Books\BooksRepositoryMockUnitTestCase;

final class CreateBookCommandHandlerTest extends BooksRepositoryMockUnitTestCase
{
    private CreateBookHandler $handler;
    private AuthorRepositoryMock $authorRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->authorRepository = new AuthorRepositoryMock();

        $this->handler = new CreateBookHandler(
            new BookCreator($this->MockRepository(), $this->authorRepository->getMockRepository())
        );
    }

    /**
     * @test
     */
    public function it_should_create_a_book(): void
    {
        $command = CreateBookCommandMother::random($this->authorRepository->getAuthorUuid());

        $book = BookMother::fromRequest($command);

        $author = AuthorMother::random($book->authorUuid()->value());

        $this->authorRepository->shouldSearchAuthor($author->uuid(), $author);
        $this->shouldSave($book);

        $this->dispatch($command, $this->handler);
    }
}