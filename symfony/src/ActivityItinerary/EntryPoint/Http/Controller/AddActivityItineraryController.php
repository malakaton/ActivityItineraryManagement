<?php

declare(strict_types=1);

namespace Academy\ActivityItinerary\EntryPoint\Http\Controller;

use Academy\ActivityItinerary\Application\AddActivity\AddActivityCommand;
use Academy\Shared\Infrastructure\Symfony\Exception\ApiResponseResource;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class AddActivityItineraryController
{
    private MessageBusInterface $commandBus;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \JsonException
     */
    public function __invoke(Request $request): Response
    {
        /** @var HandledStamp $envelope */
        $envelope = $this->commandBus->dispatch(new AddActivityCommand(
            $request->get('id'),
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