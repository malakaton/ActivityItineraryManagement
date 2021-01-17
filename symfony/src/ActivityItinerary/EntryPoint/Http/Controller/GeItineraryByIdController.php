<?php

declare(strict_types=1);

namespace Academy\ActivityItinerary\EntryPoint\Http\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class GeItineraryByIdController
{
    private MessageBusInterface $commandBus;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function __invoke(int $uuidItinerary, int $activityName): Response
    {
        echo 'ola';
//        /** @var HandledStamp $envelope */
//        $envelope = $this->commandBus->dispatch(new FindBookCommand(
//            $request->get('id')
//        ))->last(HandledStamp::class);
//
//        /** @var BookDomainResponse $bookResponse */
//        $bookResponse = $envelope->getResult();
//
//        $response = $bookResponse->getResponseByContentType($request->getContentType());
//
    }
}