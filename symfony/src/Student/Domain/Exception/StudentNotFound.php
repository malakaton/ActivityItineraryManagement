<?php

declare(strict_types=1);

namespace Academy\Student\Domain\Exception;

use Academy\Shared\Domain\DomainException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class StudentNotFound extends \Exception implements DomainException
{
    /**
     * ItineraryNotFound constructor.
     * @param string $id
     * @param int $code
     * @param Throwable|null $previous
     * @throws \JsonException
     */
    public function __construct(string $id, int $code = Response::HTTP_NOT_FOUND, Throwable $previous = null) {
        parent::__construct(
            json_encode([
                            'message' => 'The student has not been found',
                            'errors' => [
                                'uuid' => [
                                    "The student uuid {$id} doesn't exist"
                                ]
                            ]
                        ], JSON_THROW_ON_ERROR),
            $code,
            $previous
        );
    }
}