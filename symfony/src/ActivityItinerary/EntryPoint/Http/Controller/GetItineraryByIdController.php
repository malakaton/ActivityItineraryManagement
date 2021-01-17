<?php

declare(strict_types=1);

namespace Academy\ActivityItinerary\EntryPoint\Http\Controller;

use Academy\ActivityItinerary\Application\ShowListActivity\ShowListActivityCommand;
use Academy\Shared\Infrastructure\Symfony\ApiResponseResource;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class GetItineraryByIdController
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
        $envelope = $this->commandBus->dispatch(new ShowListActivityCommand(
            $request->get('id')
        ))->last(HandledStamp::class);

        return (new ApiResponseResource(
            Response::HTTP_OK,
            $envelope->getResult(),
            [],
            '',
            true)
        )->getResponse();
    }
}