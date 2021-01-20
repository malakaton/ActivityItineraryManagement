<?php

declare(strict_types=1);

namespace Academy\Itinerary\EntryPoint\Http\Controller;

use Academy\Itinerary\Application\AddActivity\AddActivityCommand;
use Academy\Shared\Infrastructure\Symfony\ApiResponseResource;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;

final class AddActivityController
{
    private MessageBusInterface $commandBus;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * Add an activity to specified itinerary.
     *
     *
     * @Route("/api/itineraries/{uuid}/activity", methods={"POST"})
     * @OA\Response(
     *     response=201,
     *     description="Activity added to itinerary successfully",
     *        @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                property="data",
     *                type="object",
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
     *                          example="Activity name: A1 added to itinerary uuid: 99f951bf-7d49-4a1a-9152-7bdee1f5ce2e successfully"
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
     *     description="The itinerary or activity has not been found on database",
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
     *                          example="The activity has not been found"
     *                     ),
     *                      @OA\Property(
     *                          property="errors",
     *                          type="array",
     *                          @OA\Items(
     *                              @OA\Property(
     *                                 property="uuid",
     *                                 type="string",
     *                                 example="The activity name A31 doesn't exist"
     *                              ),
     *                          ),
     *                     ),
     *              ),
     *        ),
     * )
     * @OA\Response(
     *     response=400,
     *     description="The activity cannot be added to itinerary beacuse the activie already exist on this itinerary. Cannot insert a duplicate activity",
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
     *                          example="The activity cannot been added, because exist on the itinerary"
     *                     ),
     *                      @OA\Property(
     *                          property="errors",
     *                          type="array",
     *                          @OA\Items(
     *                              @OA\Property(
     *                                 property="uuid",
     *                                 type="string",
     *                                 example="The activity name A1 is duplicated on itinerary uuid 99f951bf-7d49-4a1a-9152-7bdee1f5ce2e"
     *                              ),
     *                          ),
     *                     ),
     *              ),
     *        ),
     * )
     *
     * @OA\Parameter(
     *     name="uuid",
     *     in="path",
     *     description="The uuid of itinerary used to see all activities involved",
     *     @OA\Schema(type="string")
     * )
     *
     * @OA\Parameter(
     *     name="name",
     *     in="query",
     *     required=true,
     *     description="The activity name to add to itinerary",
     *     @OA\Schema(type="string")
     * )
     * @OA\Tag(name="itineraries")
     *
     * @param Request $request
     * @return Response
     * @throws \JsonException
     */
    public function __invoke(Request $request): Response
    {
        /** @var HandledStamp $envelope */
        $envelope = $this->commandBus->dispatch(new AddActivityCommand(
            $request->get('uuid'),
            $request->get('name')
        ))->last(HandledStamp::class);

        return (new ApiResponseResource(
            Response::HTTP_CREATED,
            [],
            [],
            $envelope->getResult(),
            true)
        )->getResponse();
    }
}