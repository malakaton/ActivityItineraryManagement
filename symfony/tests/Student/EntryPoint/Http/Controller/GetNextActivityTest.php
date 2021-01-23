<?php

declare(strict_types=1);

namespace Academy\Tests\Student\EntryPoint\Http\Controller;

use Academy\Evaluation\Domain\Evaluation;
use Academy\Tests\Activity\Domain\ActivityNameMother;
use Academy\Tests\Itinerary\Domain\ItineraryUuidMother;
use Academy\Tests\Student\Domain\StudentUuidMother;
use Academy\Tests\Shared\EntryPoint\EntryPointTestCase;
use Symfony\Component\HttpFoundation\Response;

final class GetNextActivityTest extends EntryPointTestCase
{

    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $kernel = self::bootKernel();

        $entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $qb = $entityManager->createQueryBuilder();

        $qb->delete(Evaluation::class)
            ->getQuery()
            ->execute();
    }

    /**
     * @test
     */
    public function next_activity_must_be_first_of_itinerary_works(): void
    {
        $this->client->request(
            'GET',
            "/api/students/".StudentUuidMother::stub_uuid."/itinerary/".ItineraryUuidMother::stub_uuid."/activity/next",
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        self::assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());

        $this->assertJsonStructure(json_decode($this->client->getResponse()->getContent(), true));
        $content = json_decode($this->client->getResponse()->getContent(), true);

        self::assertEquals(ActivityNameMother::stub_name, $content['data']['activity_name']);
        self::assertTrue($content['meta']['success']);
    }
}