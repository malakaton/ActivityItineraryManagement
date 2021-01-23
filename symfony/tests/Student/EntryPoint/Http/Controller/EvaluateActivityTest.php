<?php

declare(strict_types=1);

namespace Academy\Tests\Student\EntryPoint\Http\Controller;

use Academy\Tests\Shared\Domain\IntMother;
use Academy\Tests\Itinerary\Domain\ItineraryUuidMother;
use Academy\Tests\Shared\Domain\StringMother;
use Academy\Tests\Student\Domain\StudentUuidMother;
use Academy\Tests\Shared\Domain\UuidMother;
use Academy\Tests\Shared\EntryPoint\EntryPointTestCase;
use Symfony\Component\HttpFoundation\Response;

final class EvaluateActivityTest extends EntryPointTestCase
{
    /**
     * @test
     */
    public function evaluate_activity_not_found(): void
    {
        $uuid = UuidMother::random();

        $this->client->request(
            'POST',
            "/api/students/{$uuid}/itinerary/{$uuid}/activity/evaluate?activity_id=A2",
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'answer' => StringMother::random(),
                'inverted_time' => IntMother::random()
            ])
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
            'POST',
            "/api/students/".StudentUuidMother::stub_uuid."/itinerary/".ItineraryUuidMother::stub_uuid."/activity/evaluate?activity_id=A1",
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'answer' => "1_0_2",
                'inverted_time' => IntMother::random()
            ])
        );

        self::assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());

        $this->assertJsonStructure(json_decode($this->client->getResponse()->getContent(), true));
    }
}