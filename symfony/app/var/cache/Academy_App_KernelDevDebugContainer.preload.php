<?php

// This file has been auto-generated by the Symfony Dependency Injection Component
// You can reference it in the "opcache.preload" php.ini setting on PHP >= 7.4 when preloading is desired

use Symfony\Component\DependencyInjection\Dumper\Preloader;

if (in_array(PHP_SAPI, ['cli', 'phpdbg'], true)) {
    return;
}

require dirname(__DIR__, 3).'/vendor/autoload.php';
require __DIR__.'/ContainerCrknBAG/Academy_App_KernelDevDebugContainer.php';
require __DIR__.'/ContainerCrknBAG/getValidator_ValidatorFactoryService.php';
require __DIR__.'/ContainerCrknBAG/getValidator_PropertyInfoLoaderService.php';
require __DIR__.'/ContainerCrknBAG/getValidator_NotCompromisedPasswordService.php';
require __DIR__.'/ContainerCrknBAG/getValidator_ExpressionService.php';
require __DIR__.'/ContainerCrknBAG/getValidator_EmailService.php';
require __DIR__.'/ContainerCrknBAG/getValidator_BuilderService.php';
require __DIR__.'/ContainerCrknBAG/getValidatorService.php';
require __DIR__.'/ContainerCrknBAG/getTest_ServiceContainerService.php';
require __DIR__.'/ContainerCrknBAG/getTest_PrivateServicesLocatorService.php';
require __DIR__.'/ContainerCrknBAG/getTest_Client_HistoryService.php';
require __DIR__.'/ContainerCrknBAG/getTest_Client_CookiejarService.php';
require __DIR__.'/ContainerCrknBAG/getTest_ClientService.php';
require __DIR__.'/ContainerCrknBAG/getSluggerService.php';
require __DIR__.'/ContainerCrknBAG/getSession_Storage_NativeService.php';
require __DIR__.'/ContainerCrknBAG/getSession_Storage_MetadataBagService.php';
require __DIR__.'/ContainerCrknBAG/getSessionService.php';
require __DIR__.'/ContainerCrknBAG/getServicesResetterService.php';
require __DIR__.'/ContainerCrknBAG/getSerializer_Normalizer_ProblemService.php';
require __DIR__.'/ContainerCrknBAG/getSerializer_Normalizer_ObjectService.php';
require __DIR__.'/ContainerCrknBAG/getSerializer_Normalizer_JsonSerializableService.php';
require __DIR__.'/ContainerCrknBAG/getSerializer_Normalizer_DatetimezoneService.php';
require __DIR__.'/ContainerCrknBAG/getSerializer_Normalizer_DatetimeService.php';
require __DIR__.'/ContainerCrknBAG/getSerializer_Normalizer_DateintervalService.php';
require __DIR__.'/ContainerCrknBAG/getSerializer_Normalizer_DataUriService.php';
require __DIR__.'/ContainerCrknBAG/getSerializer_Normalizer_ConstraintViolationListService.php';
require __DIR__.'/ContainerCrknBAG/getSerializer_NameConverter_MetadataAwareService.php';
require __DIR__.'/ContainerCrknBAG/getSerializer_Mapping_ClassDiscriminatorResolverService.php';
require __DIR__.'/ContainerCrknBAG/getSerializer_Mapping_ChainLoaderService.php';
require __DIR__.'/ContainerCrknBAG/getSerializer_Mapping_CacheClassMetadataFactory_InnerService.php';
require __DIR__.'/ContainerCrknBAG/getSerializer_Mapping_CacheClassMetadataFactoryService.php';
require __DIR__.'/ContainerCrknBAG/getSerializer_Mapping_Cache_SymfonyService.php';
require __DIR__.'/ContainerCrknBAG/getSerializer_Encoder_YamlService.php';
require __DIR__.'/ContainerCrknBAG/getSerializer_Encoder_XmlService.php';
require __DIR__.'/ContainerCrknBAG/getSerializer_Encoder_JsonService.php';
require __DIR__.'/ContainerCrknBAG/getSerializer_Encoder_CsvService.php';
require __DIR__.'/ContainerCrknBAG/getSerializer_Denormalizer_UnwrappingService.php';
require __DIR__.'/ContainerCrknBAG/getSerializer_Denormalizer_ArrayService.php';
require __DIR__.'/ContainerCrknBAG/getSerializerService.php';
require __DIR__.'/ContainerCrknBAG/getSecrets_VaultService.php';
require __DIR__.'/ContainerCrknBAG/getSecrets_DecryptionKeyService.php';
require __DIR__.'/ContainerCrknBAG/getRouting_ResolverService.php';
require __DIR__.'/ContainerCrknBAG/getRouting_Loader_YmlService.php';
require __DIR__.'/ContainerCrknBAG/getRouting_Loader_XmlService.php';
require __DIR__.'/ContainerCrknBAG/getRouting_Loader_PhpService.php';
require __DIR__.'/ContainerCrknBAG/getRouting_Loader_GlobService.php';
require __DIR__.'/ContainerCrknBAG/getRouting_Loader_DirectoryService.php';
require __DIR__.'/ContainerCrknBAG/getRouting_Loader_ContainerService.php';
require __DIR__.'/ContainerCrknBAG/getRouting_Loader_Annotation_FileService.php';
require __DIR__.'/ContainerCrknBAG/getRouting_Loader_Annotation_DirectoryService.php';
require __DIR__.'/ContainerCrknBAG/getRouting_Loader_AnnotationService.php';
require __DIR__.'/ContainerCrknBAG/getRouting_LoaderService.php';
require __DIR__.'/ContainerCrknBAG/getPropertyInfo_SerializerExtractorService.php';
require __DIR__.'/ContainerCrknBAG/getPropertyInfo_ReflectionExtractorService.php';
require __DIR__.'/ContainerCrknBAG/getPropertyInfo_PhpDocExtractorService.php';
require __DIR__.'/ContainerCrknBAG/getPropertyInfoService.php';
require __DIR__.'/ContainerCrknBAG/getPropertyAccessorService.php';
require __DIR__.'/ContainerCrknBAG/getMonolog_Logger_MessengerService.php';
require __DIR__.'/ContainerCrknBAG/getMonolog_Logger_DoctrineService.php';
require __DIR__.'/ContainerCrknBAG/getMonolog_Logger_CacheService.php';
require __DIR__.'/ContainerCrknBAG/getMonolog_LoggerService.php';
require __DIR__.'/ContainerCrknBAG/getMessenger_SendersLocatorService.php';
require __DIR__.'/ContainerCrknBAG/getMessenger_RetryStrategyLocatorService.php';
require __DIR__.'/ContainerCrknBAG/getMessenger_Retry_SendFailedMessageForRetryListenerService.php';
require __DIR__.'/ContainerCrknBAG/getMessenger_Middleware_SendMessageService.php';
require __DIR__.'/ContainerCrknBAG/getMessenger_Middleware_RejectRedeliveredMessageMiddlewareService.php';
require __DIR__.'/ContainerCrknBAG/getMessenger_Middleware_FailedMessageProcessingMiddlewareService.php';
require __DIR__.'/ContainerCrknBAG/getMessenger_Middleware_DispatchAfterCurrentBusService.php';
require __DIR__.'/ContainerCrknBAG/getMessenger_Listener_StopWorkerOnRestartSignalListenerService.php';
require __DIR__.'/ContainerCrknBAG/getMessenger_DefaultBusService.php';
require __DIR__.'/ContainerCrknBAG/getMessenger_Bus_Default_Middleware_HandleMessageService.php';
require __DIR__.'/ContainerCrknBAG/getMessenger_Bus_Default_Middleware_AddBusNameStampMiddlewareService.php';
require __DIR__.'/ContainerCrknBAG/getMessenger_Bus_Default_Messenger_HandlersLocatorService.php';
require __DIR__.'/ContainerCrknBAG/getFilesystemService.php';
require __DIR__.'/ContainerCrknBAG/getFileLocatorService.php';
require __DIR__.'/ContainerCrknBAG/getErrorHandler_ErrorRenderer_SerializerService.php';
require __DIR__.'/ContainerCrknBAG/getErrorHandler_ErrorRenderer_HtmlService.php';
require __DIR__.'/ContainerCrknBAG/getErrorControllerService.php';
require __DIR__.'/ContainerCrknBAG/getDoctrine_Orm_ValidatorInitializerService.php';
require __DIR__.'/ContainerCrknBAG/getDoctrine_Orm_Validator_UniqueService.php';
require __DIR__.'/ContainerCrknBAG/getDoctrine_Orm_QuoteStrategy_DefaultService.php';
require __DIR__.'/ContainerCrknBAG/getDoctrine_Orm_NamingStrategy_UnderscoreNumberAwareService.php';
require __DIR__.'/ContainerCrknBAG/getDoctrine_Orm_Messenger_EventSubscriber_DoctrineClearEntityManagerService.php';
require __DIR__.'/ContainerCrknBAG/getDoctrine_Orm_Messenger_DoctrineSchemaSubscriberService.php';
require __DIR__.'/ContainerCrknBAG/getDoctrine_Orm_Listeners_PdoCacheAdapterDoctrineSchemaSubscriberService.php';
require __DIR__.'/ContainerCrknBAG/getDoctrine_Orm_DefaultXmlMetadataDriverService.php';
require __DIR__.'/ContainerCrknBAG/getDoctrine_Orm_DefaultMetadataDriverService.php';
require __DIR__.'/ContainerCrknBAG/getDoctrine_Orm_DefaultManagerConfiguratorService.php';
require __DIR__.'/ContainerCrknBAG/getDoctrine_Orm_DefaultListeners_AttachEntityListenersService.php';
require __DIR__.'/ContainerCrknBAG/getDoctrine_Orm_DefaultEntityManager_ValidatorLoaderService.php';
require __DIR__.'/ContainerCrknBAG/getDoctrine_Orm_DefaultEntityManager_PropertyInfoExtractorService.php';
require __DIR__.'/ContainerCrknBAG/getDoctrine_Orm_DefaultEntityManagerService.php';
require __DIR__.'/ContainerCrknBAG/getDoctrine_Orm_DefaultEntityListenerResolverService.php';
require __DIR__.'/ContainerCrknBAG/getDoctrine_Orm_DefaultConfigurationService.php';
require __DIR__.'/ContainerCrknBAG/getDoctrine_Orm_ContainerRepositoryFactoryService.php';
require __DIR__.'/ContainerCrknBAG/getDoctrine_Orm_Cache_Provider_Cache_Doctrine_Orm_Default_ResultService.php';
require __DIR__.'/ContainerCrknBAG/getDoctrine_Orm_Cache_Provider_Cache_Doctrine_Orm_Default_QueryService.php';
require __DIR__.'/ContainerCrknBAG/getDoctrine_Orm_Cache_Provider_Cache_Doctrine_Orm_Default_MetadataService.php';
require __DIR__.'/ContainerCrknBAG/getDoctrine_Dbal_Logger_Profiling_DefaultService.php';
require __DIR__.'/ContainerCrknBAG/getDoctrine_Dbal_Logger_Chain_DefaultService.php';
require __DIR__.'/ContainerCrknBAG/getDoctrine_Dbal_LoggerService.php';
require __DIR__.'/ContainerCrknBAG/getDoctrine_Dbal_DefaultConnection_EventManagerService.php';
require __DIR__.'/ContainerCrknBAG/getDoctrine_Dbal_DefaultConnection_ConfigurationService.php';
require __DIR__.'/ContainerCrknBAG/getDoctrine_Dbal_DefaultConnectionService.php';
require __DIR__.'/ContainerCrknBAG/getDoctrine_Dbal_ConnectionFactoryService.php';
require __DIR__.'/ContainerCrknBAG/getDoctrineService.php';
require __DIR__.'/ContainerCrknBAG/getDependencyInjection_Config_ContainerParametersResourceCheckerService.php';
require __DIR__.'/ContainerCrknBAG/getContainer_GetenvService.php';
require __DIR__.'/ContainerCrknBAG/getContainer_EnvVarProcessorsLocatorService.php';
require __DIR__.'/ContainerCrknBAG/getContainer_EnvVarProcessorService.php';
require __DIR__.'/ContainerCrknBAG/getConfig_Resource_SelfCheckingResourceCheckerService.php';
require __DIR__.'/ContainerCrknBAG/getCacheClearerService.php';
require __DIR__.'/ContainerCrknBAG/getCache_SystemClearerService.php';
require __DIR__.'/ContainerCrknBAG/getCache_SystemService.php';
require __DIR__.'/ContainerCrknBAG/getCache_SerializerService.php';
require __DIR__.'/ContainerCrknBAG/getCache_PropertyAccessService.php';
require __DIR__.'/ContainerCrknBAG/getCache_Messenger_RestartWorkersSignalService.php';
require __DIR__.'/ContainerCrknBAG/getCache_GlobalClearerService.php';
require __DIR__.'/ContainerCrknBAG/getCache_Doctrine_Orm_Default_ResultService.php';
require __DIR__.'/ContainerCrknBAG/getCache_Doctrine_Orm_Default_QueryService.php';
require __DIR__.'/ContainerCrknBAG/getCache_Doctrine_Orm_Default_MetadataService.php';
require __DIR__.'/ContainerCrknBAG/getCache_DefaultMarshallerService.php';
require __DIR__.'/ContainerCrknBAG/getCache_AppClearerService.php';
require __DIR__.'/ContainerCrknBAG/getCache_AppService.php';
require __DIR__.'/ContainerCrknBAG/getCache_AnnotationsService.php';
require __DIR__.'/ContainerCrknBAG/getArgumentResolver_VariadicService.php';
require __DIR__.'/ContainerCrknBAG/getArgumentResolver_SessionService.php';
require __DIR__.'/ContainerCrknBAG/getArgumentResolver_ServiceService.php';
require __DIR__.'/ContainerCrknBAG/getArgumentResolver_RequestAttributeService.php';
require __DIR__.'/ContainerCrknBAG/getArgumentResolver_RequestService.php';
require __DIR__.'/ContainerCrknBAG/getArgumentResolver_DefaultService.php';
require __DIR__.'/ContainerCrknBAG/getAnnotations_ReaderService.php';
require __DIR__.'/ContainerCrknBAG/getAnnotations_DummyRegistryService.php';
require __DIR__.'/ContainerCrknBAG/getAnnotations_CachedReaderService.php';
require __DIR__.'/ContainerCrknBAG/getAnnotations_CacheService.php';
require __DIR__.'/ContainerCrknBAG/getTemplateControllerService.php';
require __DIR__.'/ContainerCrknBAG/getRedirectControllerService.php';
require __DIR__.'/ContainerCrknBAG/getApiExceptionListenerService.php';
require __DIR__.'/ContainerCrknBAG/getItineraryRepositoryMysqlService.php';
require __DIR__.'/ContainerCrknBAG/getIndexControllerService.php';
require __DIR__.'/ContainerCrknBAG/getActivityRepositoryMysqlService.php';
require __DIR__.'/ContainerCrknBAG/getActivityItineraryRepositoryMysqlService.php';
require __DIR__.'/ContainerCrknBAG/getGeItineraryByIdControllerService.php';
require __DIR__.'/ContainerCrknBAG/getAddActivityItineraryControllerService.php';
require __DIR__.'/ContainerCrknBAG/getActivityAdderService.php';
require __DIR__.'/ContainerCrknBAG/getAddActivityHandlerService.php';
require __DIR__.'/ContainerCrknBAG/get_ServiceLocator_Beq5mCoService.php';
require __DIR__.'/ContainerCrknBAG/get_ServiceLocator_XUhQSUJService.php';
require __DIR__.'/ContainerCrknBAG/get_ServiceLocator_C9JCBPCService.php';
require __DIR__.'/ContainerCrknBAG/get_Messenger_HandlerDescriptor_J4KSUkService.php';

$classes = [];
$classes[] = 'Symfony\Bundle\FrameworkBundle\FrameworkBundle';
$classes[] = 'Doctrine\Bundle\DoctrineBundle\DoctrineBundle';
$classes[] = 'Symfony\Bundle\MonologBundle\MonologBundle';
$classes[] = 'Symfony\Component\Messenger\Handler\HandlerDescriptor';
$classes[] = 'Symfony\Component\DependencyInjection\ServiceLocator';
$classes[] = 'Academy\ActivityItinerary\Application\AddActivity\AddActivityHandler';
$classes[] = 'Academy\ActivityItinerary\Domain\ActivityAdder';
$classes[] = 'Academy\ActivityItinerary\EntryPoint\Http\Controller\AddActivityItineraryController';
$classes[] = 'Academy\ActivityItinerary\EntryPoint\Http\Controller\GeItineraryByIdController';
$classes[] = 'Academy\ActivityItinerary\Infrastructure\Persistence\ActivityItineraryRepositoryMysql';
$classes[] = 'Academy\Activity\Infrastructure\Persistence\ActivityRepositoryMysql';
$classes[] = 'Academy\App\Controller\IndexController';
$classes[] = 'Academy\Itinerary\Infrastructure\Persistence\ItineraryRepositoryMysql';
$classes[] = 'Academy\Shared\Infrastructure\Symfony\Exception\ApiExceptionListener';
$classes[] = 'Symfony\Bundle\FrameworkBundle\Controller\RedirectController';
$classes[] = 'Symfony\Bundle\FrameworkBundle\Controller\TemplateController';
$classes[] = 'Symfony\Component\Cache\DoctrineProvider';
$classes[] = 'Symfony\Component\Cache\Adapter\PhpArrayAdapter';
$classes[] = 'Doctrine\Common\Annotations\CachedReader';
$classes[] = 'Doctrine\Common\Annotations\AnnotationRegistry';
$classes[] = 'Doctrine\Common\Annotations\AnnotationReader';
$classes[] = 'Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadataFactory';
$classes[] = 'Symfony\Component\HttpKernel\Controller\ArgumentResolver';
$classes[] = 'Symfony\Component\HttpKernel\Controller\ArgumentResolver\DefaultValueResolver';
$classes[] = 'Symfony\Component\HttpKernel\Controller\ArgumentResolver\RequestValueResolver';
$classes[] = 'Symfony\Component\HttpKernel\Controller\ArgumentResolver\RequestAttributeValueResolver';
$classes[] = 'Symfony\Component\HttpKernel\Controller\ArgumentResolver\ServiceValueResolver';
$classes[] = 'Symfony\Component\HttpKernel\Controller\ArgumentResolver\SessionValueResolver';
$classes[] = 'Symfony\Component\HttpKernel\Controller\ArgumentResolver\VariadicValueResolver';
$classes[] = 'Symfony\Component\Cache\Adapter\AdapterInterface';
$classes[] = 'Symfony\Component\Cache\Adapter\AbstractAdapter';
$classes[] = 'Symfony\Component\Cache\Adapter\FilesystemAdapter';
$classes[] = 'Symfony\Component\HttpKernel\CacheClearer\Psr6CacheClearer';
$classes[] = 'Symfony\Component\Cache\Marshaller\DefaultMarshaller';
$classes[] = 'Symfony\Component\Cache\Adapter\ArrayAdapter';
$classes[] = 'Symfony\Component\HttpKernel\CacheClearer\ChainCacheClearer';
$classes[] = 'Symfony\Component\Config\Resource\SelfCheckingResourceChecker';
$classes[] = 'Symfony\Component\Config\ResourceCheckerConfigCacheFactory';
$classes[] = 'Symfony\Component\DependencyInjection\EnvVarProcessor';
$classes[] = 'Symfony\Bundle\FrameworkBundle\Controller\ControllerResolver';
$classes[] = 'Symfony\Component\HttpKernel\EventListener\DebugHandlersListener';
$classes[] = 'Symfony\Component\HttpKernel\Debug\FileLinkFormatter';
$classes[] = 'Symfony\Component\DependencyInjection\Config\ContainerParametersResourceChecker';
$classes[] = 'Symfony\Component\HttpKernel\EventListener\DisallowRobotsIndexingListener';
$classes[] = 'Doctrine\Bundle\DoctrineBundle\Registry';
$classes[] = 'Doctrine\Bundle\DoctrineBundle\ConnectionFactory';
$classes[] = 'Doctrine\DBAL\Connection';
$classes[] = 'Doctrine\DBAL\Configuration';
$classes[] = 'Symfony\Bridge\Doctrine\ContainerAwareEventManager';
$classes[] = 'Symfony\Bridge\Doctrine\Logger\DbalLogger';
$classes[] = 'Doctrine\DBAL\Logging\LoggerChain';
$classes[] = 'Doctrine\DBAL\Logging\DebugStack';
$classes[] = 'Doctrine\Bundle\DoctrineBundle\Repository\ContainerRepositoryFactory';
$classes[] = 'Doctrine\ORM\Configuration';
$classes[] = 'Doctrine\Bundle\DoctrineBundle\Mapping\ContainerEntityListenerResolver';
$classes[] = 'Doctrine\ORM\Proxy\Autoloader';
$classes[] = 'Doctrine\ORM\EntityManager';
$classes[] = 'Symfony\Bridge\Doctrine\PropertyInfo\DoctrineExtractor';
$classes[] = 'Symfony\Bridge\Doctrine\Validator\DoctrineLoader';
$classes[] = 'Doctrine\ORM\Tools\AttachEntityListenersListener';
$classes[] = 'Doctrine\Bundle\DoctrineBundle\ManagerConfigurator';
$classes[] = 'Doctrine\Persistence\Mapping\Driver\MappingDriverChain';
$classes[] = 'Doctrine\ORM\Mapping\Driver\SimplifiedXmlDriver';
$classes[] = 'Symfony\Bridge\Doctrine\SchemaListener\PdoCacheAdapterDoctrineSchemaSubscriber';
$classes[] = 'Symfony\Bridge\Doctrine\SchemaListener\MessengerTransportDoctrineSchemaSubscriber';
$classes[] = 'Symfony\Bridge\Doctrine\Messenger\DoctrineClearEntityManagerWorkerSubscriber';
$classes[] = 'Doctrine\ORM\Mapping\UnderscoreNamingStrategy';
$classes[] = 'Doctrine\ORM\Mapping\DefaultQuoteStrategy';
$classes[] = 'Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntityValidator';
$classes[] = 'Symfony\Bridge\Doctrine\Validator\DoctrineInitializer';
$classes[] = 'Symfony\Component\HttpKernel\Controller\ErrorController';
$classes[] = 'Symfony\Component\ErrorHandler\ErrorRenderer\HtmlErrorRenderer';
$classes[] = 'Symfony\Component\ErrorHandler\ErrorRenderer\SerializerErrorRenderer';
$classes[] = 'Symfony\Component\EventDispatcher\EventDispatcher';
$classes[] = 'Symfony\Component\HttpKernel\EventListener\ErrorListener';
$classes[] = 'Symfony\Component\HttpKernel\Config\FileLocator';
$classes[] = 'Symfony\Component\Filesystem\Filesystem';
$classes[] = 'Symfony\Component\HttpKernel\HttpKernel';
$classes[] = 'Academy\App\Kernel';
$classes[] = 'Symfony\Component\HttpKernel\EventListener\LocaleAwareListener';
$classes[] = 'Symfony\Component\HttpKernel\EventListener\LocaleListener';
$classes[] = 'Symfony\Component\Messenger\Handler\HandlersLocator';
$classes[] = 'Symfony\Component\Messenger\Middleware\AddBusNameStampMiddleware';
$classes[] = 'Symfony\Component\Messenger\Middleware\HandleMessageMiddleware';
$classes[] = 'Symfony\Component\Messenger\MessageBus';
$classes[] = 'Symfony\Component\Messenger\EventListener\StopWorkerOnRestartSignalListener';
$classes[] = 'Symfony\Component\Messenger\Middleware\DispatchAfterCurrentBusMiddleware';
$classes[] = 'Symfony\Component\Messenger\Middleware\FailedMessageProcessingMiddleware';
$classes[] = 'Symfony\Component\Messenger\Middleware\RejectRedeliveredMessageMiddleware';
$classes[] = 'Symfony\Component\Messenger\Middleware\SendMessageMiddleware';
$classes[] = 'Symfony\Component\Messenger\EventListener\SendFailedMessageForRetryListener';
$classes[] = 'Symfony\Component\Messenger\Transport\Sender\SendersLocator';
$classes[] = 'Symfony\Bridge\Monolog\Handler\ConsoleHandler';
$classes[] = 'Monolog\Handler\StreamHandler';
$classes[] = 'Symfony\Bridge\Monolog\Logger';
$classes[] = 'Monolog\Processor\PsrLogMessageProcessor';
$classes[] = 'Symfony\Component\DependencyInjection\ParameterBag\ContainerBag';
$classes[] = 'Symfony\Component\PropertyAccess\PropertyAccessor';
$classes[] = 'Symfony\Component\PropertyInfo\PropertyInfoExtractor';
$classes[] = 'Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor';
$classes[] = 'Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor';
$classes[] = 'Symfony\Component\PropertyInfo\Extractor\SerializerExtractor';
$classes[] = 'Symfony\Component\HttpFoundation\RequestStack';
$classes[] = 'Symfony\Component\HttpKernel\EventListener\ResponseListener';
$classes[] = 'Symfony\Bundle\FrameworkBundle\Routing\Router';
$classes[] = 'Symfony\Component\Routing\RequestContext';
$classes[] = 'Symfony\Component\HttpKernel\EventListener\RouterListener';
$classes[] = 'Symfony\Bundle\FrameworkBundle\Routing\DelegatingLoader';
$classes[] = 'Symfony\Bundle\FrameworkBundle\Routing\AnnotatedRouteControllerLoader';
$classes[] = 'Symfony\Component\Routing\Loader\AnnotationDirectoryLoader';
$classes[] = 'Symfony\Component\Routing\Loader\AnnotationFileLoader';
$classes[] = 'Symfony\Component\Routing\Loader\ContainerLoader';
$classes[] = 'Symfony\Component\Routing\Loader\DirectoryLoader';
$classes[] = 'Symfony\Component\Routing\Loader\GlobFileLoader';
$classes[] = 'Symfony\Component\Routing\Loader\PhpFileLoader';
$classes[] = 'Symfony\Component\Routing\Loader\XmlFileLoader';
$classes[] = 'Symfony\Component\Routing\Loader\YamlFileLoader';
$classes[] = 'Symfony\Component\Config\Loader\LoaderResolver';
$classes[] = 'Symfony\Component\String\LazyString';
$classes[] = 'Symfony\Bundle\FrameworkBundle\Secrets\SodiumVault';
$classes[] = 'Symfony\Component\Serializer\Serializer';
$classes[] = 'Symfony\Component\Serializer\Normalizer\ArrayDenormalizer';
$classes[] = 'Symfony\Component\Serializer\Normalizer\UnwrappingDenormalizer';
$classes[] = 'Symfony\Component\Serializer\Encoder\CsvEncoder';
$classes[] = 'Symfony\Component\Serializer\Encoder\JsonEncoder';
$classes[] = 'Symfony\Component\Serializer\Encoder\XmlEncoder';
$classes[] = 'Symfony\Component\Serializer\Encoder\YamlEncoder';
$classes[] = 'Psr\Cache\CacheItemPoolInterface';
$classes[] = 'Symfony\Component\Serializer\Mapping\Factory\CacheClassMetadataFactory';
$classes[] = 'Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory';
$classes[] = 'Symfony\Component\Serializer\Mapping\Loader\LoaderChain';
$classes[] = 'Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader';
$classes[] = 'Symfony\Component\Serializer\Mapping\ClassDiscriminatorFromClassMetadata';
$classes[] = 'Symfony\Component\Serializer\NameConverter\MetadataAwareNameConverter';
$classes[] = 'Symfony\Component\Serializer\Normalizer\ConstraintViolationListNormalizer';
$classes[] = 'Symfony\Component\Serializer\Normalizer\DataUriNormalizer';
$classes[] = 'Symfony\Component\Serializer\Normalizer\DateIntervalNormalizer';
$classes[] = 'Symfony\Component\Serializer\Normalizer\DateTimeNormalizer';
$classes[] = 'Symfony\Component\Serializer\Normalizer\DateTimeZoneNormalizer';
$classes[] = 'Symfony\Component\Serializer\Normalizer\JsonSerializableNormalizer';
$classes[] = 'Symfony\Component\Serializer\Normalizer\ObjectNormalizer';
$classes[] = 'Symfony\Component\Serializer\Normalizer\ProblemNormalizer';
$classes[] = 'Symfony\Component\DependencyInjection\ContainerInterface';
$classes[] = 'Symfony\Component\HttpKernel\DependencyInjection\ServicesResetter';
$classes[] = 'Symfony\Component\HttpFoundation\Session\Session';
$classes[] = 'Symfony\Component\HttpFoundation\Session\Storage\MetadataBag';
$classes[] = 'Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage';
$classes[] = 'Symfony\Component\HttpKernel\EventListener\SessionListener';
$classes[] = 'Symfony\Component\String\Slugger\AsciiSlugger';
$classes[] = 'Symfony\Component\HttpKernel\EventListener\StreamedResponseListener';
$classes[] = 'Symfony\Bundle\FrameworkBundle\KernelBrowser';
$classes[] = 'Symfony\Component\BrowserKit\CookieJar';
$classes[] = 'Symfony\Component\BrowserKit\History';
$classes[] = 'Symfony\Bundle\FrameworkBundle\Test\TestContainer';
$classes[] = 'Symfony\Component\HttpKernel\EventListener\TestSessionListener';
$classes[] = 'Symfony\Component\HttpKernel\EventListener\ValidateRequestListener';
$classes[] = 'Symfony\Component\Validator\Validator\ValidatorInterface';
$classes[] = 'Symfony\Component\Validator\ValidatorBuilder';
$classes[] = 'Symfony\Component\Validator\Validation';
$classes[] = 'Symfony\Component\Validator\Constraints\EmailValidator';
$classes[] = 'Symfony\Component\Validator\Constraints\ExpressionValidator';
$classes[] = 'Symfony\Component\Validator\Constraints\NotCompromisedPasswordValidator';
$classes[] = 'Symfony\Component\Validator\Mapping\Loader\PropertyInfoLoader';
$classes[] = 'Symfony\Component\Validator\ContainerConstraintValidatorFactory';

Preloader::preload($classes);
