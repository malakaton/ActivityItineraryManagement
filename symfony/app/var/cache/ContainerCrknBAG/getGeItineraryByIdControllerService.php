<?php

namespace ContainerCrknBAG;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getGeItineraryByIdControllerService extends Academy_App_KernelDevDebugContainer
{
    /**
     * Gets the public 'Academy\ActivityItinerary\EntryPoint\Http\Controller\GeItineraryByIdController' shared autowired service.
     *
     * @return \Academy\ActivityItinerary\EntryPoint\Http\Controller\GeItineraryByIdController
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/src/ActivityItinerary/EntryPoint/Http/Controller/GeItineraryByIdController.php';

        return $container->services['Academy\\ActivityItinerary\\EntryPoint\\Http\\Controller\\GeItineraryByIdController'] = new \Academy\ActivityItinerary\EntryPoint\Http\Controller\GeItineraryByIdController(($container->services['messenger.default_bus'] ?? $container->load('getMessenger_DefaultBusService')));
    }
}
