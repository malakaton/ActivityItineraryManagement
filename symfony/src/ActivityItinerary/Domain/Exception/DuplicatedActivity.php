<?php

declare(strict_types=1);

namespace Academy\ActivityItinerary\Domain\Exception;

use Academy\Shared\Domain\DomainException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class DuplicatedActivity extends \Exception implements DomainException
{
    /**
     * DuplicatedActivity constructor.
     * @param string $itineraryUuid
     * @param string $activityName
     * @param int $code
     * @param Throwable|null $previous
     * @throws \JsonException
     */
    public function __construct(
        string $itineraryUuid,
        string $activityName,
        int $code = Response::HTTP_BAD_REQUEST,
        Throwable $previous = null
    ) {
        parent::__construct(
            json_encode([
                            'message' => 'The activity cannot been added, because exist on the itinerary',
                            'errors' => [
                                'uuid' => [
                                    "The activity name {$activityName} is duplicated on itinerary uuid {$itineraryUuid}"
                                ]
                            ]
                        ], JSON_THROW_ON_ERROR),
            $code,
            $previous
        );
    }
}