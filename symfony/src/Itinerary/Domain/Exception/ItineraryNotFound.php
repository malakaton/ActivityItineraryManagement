<?php

declare(strict_types=1);

namespace Academy\Itinerary\Domain\Exception;

use Academy\Shared\Domain\DomainException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class ItineraryNotFound extends \Exception implements DomainException
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
                'message' => 'The itinerary has not been found',
                'errors' => [
                    'uuid' => [
                        "The itinerary uuid {$id} doesn't exist"
                    ]
                ]
            ], JSON_THROW_ON_ERROR),
            $code,
            $previous
        );
    }
}