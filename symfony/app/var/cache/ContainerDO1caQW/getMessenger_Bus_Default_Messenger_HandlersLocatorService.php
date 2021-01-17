<?php

namespace ContainerDO1caQW;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getMessenger_Bus_Default_Messenger_HandlersLocatorService extends Academy_App_KernelDevDebugContainer
{
    /**
     * Gets the private 'messenger.bus.default.messenger.handlers_locator' shared service.
     *
     * @return \Symfony\Component\Messenger\Handler\HandlersLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/symfony/messenger/Handler/HandlersLocatorInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/messenger/Handler/HandlersLocator.php';

        return $container->privates['messenger.bus.default.messenger.handlers_locator'] = new \Symfony\Component\Messenger\Handler\HandlersLocator(['Academy\\ActivityItinerary\\Application\\AddActivity\\AddActivityCommand' => new RewindableGenerator(function () use ($container) {
            yield 0 => ($container->privates['.messenger.handler_descriptor.J4_kSUk'] ?? $container->load('get_Messenger_HandlerDescriptor_J4KSUkService'));
        }, 1)]);
    }
}
