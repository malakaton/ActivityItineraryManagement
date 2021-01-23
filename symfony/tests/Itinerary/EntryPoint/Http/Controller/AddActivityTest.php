<?php

declare(strict_types=1);

namespace Academy\Tests\Itinerary\EntryPoint\Http\Controller;

use Academy\ActivityItinerary\Domain\ActivityItinerary;
use Academy\Tests\Activity\Domain\ActivityNameMother;
use Academy\Tests\Activity\Domain\ActivityUuidMother;
use Academy\Tests\Itinerary\Domain\ItineraryUuidMother;
use Academy\Tests\Shared\EntryPoint\EntryPointTestCase;
use Symfony\Component\HttpFoundation\Response;

final class AddActivityTest extends EntryPointTestCase
{
    private const ACTIVITY_NAME_STUB = 'A99';

    public function setUp(): void
    {
        parent::setUp();

        $kernel = self::bootKernel();

        $entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $qb = $entityManager->createQueryBuilder();

        $qb->delete(ActivityItinerary::class, 'ai')
            ->where('ai.activityUuid = (:uuid)')
            ->setParameter('uuid', ActivityUuidMother::FAKE_ACTIVITY_UUID_STUB)
            ->getQuery()
            ->execute();
    }

    /**
     * @test
     */
    public function activity_not_found(): void
    {
        $this->client->request(
            'POST',
            "/api/itineraries/".ItineraryUuidMother::stub_uuid."/activity?name=A100",
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            ''
        );

        self::assertEquals(Response::HTTP_NOT_FOUND, $this->client->getResponse()->getStatusCode());

        $this->assertJsonStructure(json_decode($this->client->getResponse()->getContent(), true));
    }

    /**
     * @test
     */
    public function add_activity_itinerary_works(): void
    {
        $this->client->request(
            'POST',
            "/api/itineraries/".ItineraryUuidMother::stub_uuid."/activity?name=" . ActivityNameMother::FAKE_ACTIVITY_NAME_STUB,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            ''
        );

        self::assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());

        $this->assertJsonStructure(json_decode($this->client->getResponse()->getContent(), true));
    }
}