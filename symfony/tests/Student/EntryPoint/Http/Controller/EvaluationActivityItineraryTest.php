<?php

declare(strict_types=1);

namespace Academy\Tests\Student\EntryPoint\Http\Controller;

use Academy\Tests\Itinerary\Domain\ItineraryUuidMother;
use Academy\Tests\Student\Domain\StudentUuidMother;
use Academy\Tests\Shared\Domain\UuidMother;
use Academy\Tests\Shared\EntryPoint\EntryPointTestCase;
use Symfony\Component\HttpFoundation\Response;

final class EvaluationActivityItineraryTest extends EntryPointTestCase
{
    /**
     * @test
     */
    public function student_not_found(): void
    {
        $uuid = UuidMother::random();

        $this->client->request(
            'GET',
            "/api/students/{$uuid}/itinerary/".ItineraryUuidMother::stub_uuid."/evaluation",
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
    public function evaluate_activity_works(): void
    {
        $this->client->request(
            'GET',
            "/api/students/".StudentUuidMother::stub_uuid."/itinerary/".ItineraryUuidMother::stub_uuid."/evaluation",
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        self::assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());

        $this->assertJsonStructure(json_decode($this->client->getResponse()->getContent(), true));
    }
}