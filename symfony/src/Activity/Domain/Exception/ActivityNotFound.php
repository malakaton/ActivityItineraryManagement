<?php

declare(strict_types=1);

namespace Academy\Activity\Domain\Exception;

use Academy\Shared\Domain\DomainException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class ActivityNotFound extends \Exception implements DomainException
{
    /**
     * ActivityNotFound constructor.
     * @param string $name
     * @param int $code
     * @param Throwable|null $previous
     * @throws \JsonException
     */
    public function __construct(string $name, int $code = Response::HTTP_NOT_FOUND, Throwable $previous = null) {
        parent::__construct(
            json_encode([
                            'message' => 'The activity has not been found',
                            'errors' => [
                                'uuid' => [
                                    "The activity name {$name} doesn't exist"
                                ]
                            ]
                        ], JSON_THROW_ON_ERROR),
            $code,
            $previous
        );
    }
}