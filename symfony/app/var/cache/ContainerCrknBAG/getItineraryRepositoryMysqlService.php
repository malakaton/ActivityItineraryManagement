<?php

namespace ContainerCrknBAG;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getItineraryRepositoryMysqlService extends Academy_App_KernelDevDebugContainer
{
    /**
     * Gets the private 'Academy\Itinerary\Infrastructure\Persistence\ItineraryRepositoryMysql' shared autowired service.
     *
     * @return \Academy\Itinerary\Infrastructure\Persistence\ItineraryRepositoryMysql
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/src/Itinerary/Domain/ItineraryRepository.php';
        include_once \dirname(__DIR__, 4).'/src/Itinerary/Infrastructure/Persistence/ItineraryRepositoryMysql.php';

        return $container->privates['Academy\\Itinerary\\Infrastructure\\Persistence\\ItineraryRepositoryMysql'] = new \Academy\Itinerary\Infrastructure\Persistence\ItineraryRepositoryMysql(($container->services['doctrine.orm.default_entity_manager'] ?? $container->load('getDoctrine_Orm_DefaultEntityManagerService')));
    }
}
