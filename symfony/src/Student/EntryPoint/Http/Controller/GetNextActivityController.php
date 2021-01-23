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
     * Calculate the next activity that student need to do on the activity itinerary
     *
     *
     * @Route("/api/students/{student_uuid}/itinerary/{itinerary_uuid}/activity/next", methods={"GET"})
     * @OA\Response(
     *     response=200,
     *     description="Returns the next activity name that student need to resolve",
     *        @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                property="data",
     *                type="object",
     *                     @OA\Property(
     *                          property="activity_name",
     *                          type="string",
     *                          example="A3"
     *                     ),
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
     * @OA\Response(
     *     response=204,
     *     description="The student has been finish all activities from itinerary"
     * )
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
            new GetNextActivityCommand(
                $request->get('student_uuid'),
                $request->get('itinerary_uuid')
            )
        )->last(HandledStamp::class);

        return (new ApiResponseResource(
            count($envelope->getResult()) >= 1 ? Response::HTTP_OK : Response::HTTP_NO_CONTENT,
            $envelope->getResult(),
            [],
            '',
            true
        )
        )->getResponse();
    }
}