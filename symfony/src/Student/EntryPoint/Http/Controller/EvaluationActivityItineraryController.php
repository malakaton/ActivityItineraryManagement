<?php

declare(strict_types=1);

namespace Academy\Student\EntryPoint\Http\Controller;

use Academy\Shared\Infrastructure\Symfony\ApiResponseResource;
use Academy\Student\Application\EvaluationActivityItinerary\EvaluationActivityItineraryCommand;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;

final class EvaluationActivityItineraryController
{
    private MessageBusInterface $commandBus;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * Get all activities with his score and time done by student from determinate activity itinerary.
     *
     *
     * @Route("/api/students/{student_uuid}/itinerary/{itinerary_uuid}/evaluation", methods={"GET"})
     * @OA\Response(
     *     response=200,
     *     description="Returns the evaluation of student with all activites done with his score and inverted time",
     *        @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                property="data",
     *                type="object",
     *                     @OA\Property(
     *                          property="student_uuid",
     *                          type="string",
     *                          example="70f066f6-1cb7-4c45-97e2-287f0258ba02"
     *                     ),
     *                     @OA\Property(
     *                          property="itinerary_uuid",
     *                          type="string",
     *                          example="99f951bf-7d49-4a1a-9152-7bdee1f5ce2e"
     *                     ),
     *                     @OA\Property(
     *                               property="done_activities",
     *                               type="array",
     *                               example = {{
     *                                   "activity_name": "A1",
     *                                   "create_date": "2021-01-21 00:40:19",
     *                                   "answer": "1_0_1",
     *                                   "inverted_time": 10,
     *                                   "score": 75,
     *                                   "percentage_inverted_time": 50
     *                              }, {
     *                                   "activity_name": "A3",
     *                                   "create_date": "2021-01-21 01:40:19",
     *                                   "answer": "1_0_2",
     *                                   "inverted_time": 990,
     *                                   "score": 50,
     *                                   "percentage_inverted_time": 100
     *                          }},
     *                        @OA\Items(
     *                              @OA\Property(
     *                                 property="activity_name",
     *                                 type="string",
     *                                 example="A1"
     *                              ),
     *                              @OA\Property(
     *                                 property="create_date",
     *                                 type="datetime",
     *                                 example="2021-01-21 00:40:19"
     *                              ),
     *                              @OA\Property(
     *                                 property="answer",
     *                                 type="string",
     *                                 example="1_0_1"
     *                              ),
     *                              @OA\Property(
     *                                 property="inverted_time",
     *                                 type="number",
     *                                 example="10"
     *                              ),
     *                              @OA\Property(
     *                                 property="score",
     *                                 type="number",
     *                                 example="100"
     *                              ),
     *                              @OA\Property(
     *                                 property="percentage_inverted_time",
     *                                 type="number",
     *                                 example="67"
     *                              ),
     *                        ),
     *                    ),
     *                ),
     *                @OA\Property(
     *                  property="meta",
     *                  type="object",
     *                     @OA\Property(
     *                          property="success",
     *                          type="boolean",
     *                          example="true"
     *                     ),
     *                     @OA\Property(
     *                          property="message",
     *                          type="string",
     *                          example=""
     *                     ),
     *                      @OA\Property(
     *                          property="errors",
     *                          type="array",
     *                          @OA\Items(),
     *                     ),
     *              ),
     *        ),
     * )
     * @OA\Response(
     *     response=404,
     *     description="The student or itinerary has not been found on database",
     *        @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                  property="data",
     *                  type="object",
     *                ),
     *                @OA\Property(
     *                  property="meta",
     *                  type="object",
     *                     @OA\Property(
     *                          property="success",
     *                          type="boolean",
     *                          example="false"
     *                     ),
     *                     @OA\Property(
     *                          property="message",
     *                          type="string",
     *                          example="The student has not been found"
     *                     ),
     *                      @OA\Property(
     *                          property="errors",
     *                          type="array",
     *                          @OA\Items(
     *                              @OA\Property(
     *                                 property="uuid",
     *                                 type="string",
     *                                 example="The student uuid 99f951bf-7d49-4a1a-9152-7bdee1f5ce21 doesn't exist"
     *                              ),
     *                          ),
     *                     ),
     *              ),
     *        ),
     * )
     *
     *
     * @OA\Tag(name="students")
     * @param Request $request
     * @return Response
     * @throws \JsonException
     */
    public function __invoke(Request $request): Response
    {
        /** @var HandledStamp $envelope */
        $envelope = $this->commandBus->dispatch(
            new EvaluationActivityItineraryCommand(
                $request->get('student_uuid'),
                $request->get('itinerary_uuid')
            )
        )->last(HandledStamp::class);

        return (new ApiResponseResource(
             Response::HTTP_OK,
            $envelope->getResult(),
            [],
            '',
            true
        )
        )->getResponse();
    }
}