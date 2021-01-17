<?php

namespace ContainerDO1caQW;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getApiExceptionListenerService extends Academy_App_KernelDevDebugContainer
{
    /**
     * Gets the private 'Academy\Shared\Infrastructure\Symfony\Exception\ApiExceptionListener' shared autowired service.
     *
     * @return \Academy\Shared\Infrastructure\Symfony\Exception\ApiExceptionListener
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/src/Shared/Infrastructure/Symfony/Exception/ApiExceptionListener.php';

        return $container->privates['Academy\\Shared\\Infrastructure\\Symfony\\Exception\\ApiExceptionListener'] = new \Academy\Shared\Infrastructure\Symfony\Exception\ApiExceptionListener(($container->privates['monolog.logger'] ?? $container->load('getMonolog_LoggerService')));
    }
}
