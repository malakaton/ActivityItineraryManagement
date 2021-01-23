<?php

declare(strict_types=1);

namespace Academy\Tests\Itinerary\EntryPoint\Http\Controller;

use Academy\Tests\Itinerary\Domain\ItineraryUuidMother;
use Academy\Tests\Shared\Domain\UuidMother;
use Academy\Tests\Shared\EntryPoint\EntryPointTestCase;
use Symfony\Component\HttpFoundation\Response;

final class ListingActivityTest extends EntryPointTestCase
{
    /**
     * @test
     */
    public function itinerary_not_found(): void
    {
        $uuid = UuidMother::random();

        $this->client->request(
            'GET',
            "/api/itineraries/{$uuid}/activity",
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        self::assertEquals(Response::HTTP_NOT_FOUND, $this->client->getResponse()->getStatusCode());

        $this->assertJsonStructure(json_decode($this->client->getResponse()->getContent(), true));
    }

    /**
     * @test
     */
    public function listing_activities_works(): void
    {
        $this->client->request(
            'GET',
            "/api/itineraries/".ItineraryUuidMother::stub_uuid."/activity",
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        self::assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());

        $this->assertJsonStructure(json_decode($this->client->getResponse()->getContent(), true));
    }
}