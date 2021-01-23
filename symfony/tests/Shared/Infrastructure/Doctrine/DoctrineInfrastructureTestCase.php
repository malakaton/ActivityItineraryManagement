<?php

declare(strict_types=1);

namespace Academy\Tests\Shared\Infrastructure\Doctrine;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class DoctrineInfrastructureTestCase extends KernelTestCase
{
    protected ?EntityManager $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    protected function repository($className)
    {
        return new $className($this->entityManager);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null;
    }


    protected function truncateEntity($className): void
    {
        $qb = $this->entityManager->createQueryBuilder();

        $qb->delete($className, 'e')
            ->getQuery()
            ->execute();
    }
}
