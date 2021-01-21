<?php

declare(strict_types=1);

namespace Academy\Evaluation\Domain;

use Academy\Itinerary\Domain\IItineraryGuard;
use Academy\Itinerary\Domain\ItineraryUuid;
use Academy\Student\Domain\IStudentGuard;
use Academy\Student\Domain\StudentUuid;
use Psr\Log\LoggerInterface;

final class EvaluationFinder
{
    private IStudentGuard $studentGuard;
    private IItineraryGuard $itineraryGuard;
    private EvaluationRepository $evaluationRepository;
    private LoggerInterface $logger;

    public function __construct(
        IStudentGuard $studentGuard,
        IItineraryGuard $itineraryGuard,
        EvaluationRepository $evaluationRepository,
        LoggerInterface $logger
    ) {
        $this->studentGuard = $studentGuard;
        $this->itineraryGuard = $itineraryGuard;
        $this->evaluationRepository = $evaluationRepository;
        $this->logger = $logger;
    }

    /**
     * @param StudentUuid $studentUuid
     * @param ItineraryUuid $itineraryUuid
     * @return array
     * @throws \JsonException
     */
    public function __invoke(
        StudentUuid $studentUuid,
        ItineraryUuid $itineraryUuid
    ): array
    {
        $this->studentGuard->guard($studentUuid);
        $this->itineraryGuard->guard($itineraryUuid);

        $this->logger->info("Access to evaluation of student uuid: {$studentUuid->value()} on the itinerary uuid {$itineraryUuid->value()} done successfully");

        return [
            'student_uuid' => $studentUuid->value(),
            'itinerary_uuid' => $itineraryUuid->value(),
            'done_activities' => $this->_toArray(
                $this->evaluationRepository->getEvaluationByStudentItineraryUuid($studentUuid, $itineraryUuid)
            )
        ];
    }

    /**
     * @param array $activityList
     * @return array
     * @throws \JsonException
     */
    private function _toArray(array $activityList): array
    {
        $response = [];

        foreach ($activityList as $activity) {
            $response[] = [
                'activity_name' => $activity['name.value'],
                'create_date' => $activity['createDate.value']->format('Y-m-d H:i:s'),
                'answer' => $activity['answer.value'],
                'inverted_time' => $activity['invertedTime.value'],
                'score' => $activity['score.value'],
                'percentage_inverted_time' => $activity['percentageInvertedTime.value']
            ];
        }

        return $response;
    }
}