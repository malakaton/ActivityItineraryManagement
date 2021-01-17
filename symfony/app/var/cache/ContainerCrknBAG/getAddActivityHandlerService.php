<?php

namespace ContainerCrknBAG;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getAddActivityHandlerService extends Academy_App_KernelDevDebugContainer
{
    /**
     * Gets the private 'Academy\ActivityItinerary\Application\AddActivity\AddActivityHandler' shared autowired service.
     *
     * @return \Academy\ActivityItinerary\Application\AddActivity\AddActivityHandler
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/symfony/messenger/Handler/MessageHandlerInterface.php';
        include_once \dirname(__DIR__, 4).'/src/ActivityItinerary/Application/AddActivity/AddActivityHandler.php';

        return $container->privates['Academy\\ActivityItinerary\\Application\\AddActivity\\AddActivityHandler'] = new \Academy\ActivityItinerary\Application\AddActivity\AddActivityHandler(($container->privates['Academy\\ActivityItinerary\\Domain\\ActivityAdder'] ?? $container->load('getActivityAdderService')));
    }
}
