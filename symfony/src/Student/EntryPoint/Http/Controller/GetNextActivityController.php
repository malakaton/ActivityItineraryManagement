<?php

declare(strict_types=1);

namespace Academy\Student\EntryPoint\Http\Controller;

use Academy\Shared\Infrastructure\Symfony\ApiResponseResource;
use Academy\Student\Application\GetNextActivity\GetNextActivityCommand;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;

final class GetNextActivityController
{
    private MessageBusInterface $commandBus;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * List the activities of the specified itinerary.
     *
     *
     * @Route("/api/students/{student_uuid}/itinerary/{itinerary_uuid}/activity/next", methods={"GET"})
     * @OA\Response(
     *     response=200,
     *     description="Returns the activities of an itinerary",
     *        @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                property="data",
     *                type="object",
     *                     @OA\Property(
     *                          property="itinerary_uuid",
     *                          type="string",
     *                          example="99f951bf-7d49-4a1a-9152-7bdee1f5ce2e"
     *                     ),
     *                     @OA\Property(
     *                               property="activities",
     *                               type="array",
     *                               example = {{
     *                                  "activity_name": "A1",
     *                                  "order": "1",
     *                                  "level": "1",
     *                                  "time": "120",
     *                                  "solution": "1_0_2"
     *                              }, {
     *                                  "activity_name": "A2",
     *                                  "order": "2",
     *                                  "level": "1",
     *                                  "time": "90",
     *                                  "solution": "20_-4_9"
     *                          }},
     *                        @OA\Items(
     *                              @OA\Property(
     *                                 property="activity_name",
     *                                 type="string",
     *                                 example="A1"
     *                              ),
     *                              @OA\Property(
     *                                 property="order",
     *                                 type="number",
     *                                 example="1"
     *                              ),
     *                              @OA\Property(
     *                                 property="level",
     *                                 type="number",
     *                                 example="1"
     *                              ),
     *                              @OA\Property(
     *                                 property="time",
     *                                 type="number",
     *                                 example="120"
     *                              ),
     *                              @OA\Property(
     *                                 property="solution",
     *                                 type="string",
     *                                 example="1_0_2"
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
     *     description="The itinerary has not been found on database",
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
     *                          example="The itinerary has not been found"
     *                     ),
     *                      @OA\Property(
     *                          property="errors",
     *                          type="array",
     *                          @OA\Items(
     *                              @OA\Property(
     *                                 property="uuid",
     *                                 type="string",
     *                                 example="The itinerary uuid 99f951bf-7d49-4a1a-9152-7bdee1f5ce21 doesn't exist"
     *                              ),
     *                          ),
     *                     ),
     *              ),
     *        ),
     * )
     * @OA\Parameter(
     *     name="uuid",
     *     in="path",
     *     description="The uuid of itinerary used to see all activities involved",
     *     @OA\Schema(type="string")
     * )
     * @OA\Tag(name="students")
     * @param Request $request
     * @return Response
     * @throws \JsonException
     */
    public function __invoke(Request $request): Response
    {
        /** @var HandledStamp $envelope */
        $envelope = $this->commandBus->dispatch(
            new GetNextActivityCommand(
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