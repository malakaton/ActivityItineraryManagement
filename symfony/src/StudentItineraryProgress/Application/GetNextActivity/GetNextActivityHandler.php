<?php

declare(strict_types=1);

namespace Academy\StudentItineraryProgress\Application\GetNextActivity;

use Academy\Itinerary\Domain\ItineraryUuid;
use Academy\StudentItineraryProgress\Domain\StudentNextActivity;
use Academy\Student\Domain\StudentUuid;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class GetNextActivityHandler implements MessageHandlerInterface
{
    private StudentNextActivity $studentNextActivity;

    public function __construct(StudentNextActivity $studentNextActivity)
    {
        $this->studentNextActivity = $studentNextActivity;
    }

    /**
     * @param GetNextActivityCommand $command
     * @return array|null
     */
    public function __invoke(GetNextActivityCommand $command): ?array
    {
        $studentUuid = new StudentUuid($command->studentUuid());
        $itineraryUuid = new ItineraryUuid($command->itineraryUuid());

        return $this->studentNextActivity->__invoke($studentUuid, $itineraryUuid);
    }
}
