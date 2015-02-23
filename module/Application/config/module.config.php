<?php

namespace Application;

return array(
    'router' => array(
        'routes' => array(
            'category' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/category[/page/:page][/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '\d+',
                        'page' => '\d+'
                    ),
                    'defaults' => array(
                        'controller' => __NAMESPACE__ . '\\Controller\\Category',
                        'action' => 'index',
                        'page' => 1
                    ),
                ),
            ),
            'priority' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/priority[/page/:page][/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '\d+',
                        'page' => '\d+'
                    ),
                    'defaults' => array(
                        'controller' => __NAMESPACE__ . '\\Controller\\Priority',
                        'action' => 'index',
                        'page' => 1
                    ),
                ),
            ),
            'interaction' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/interaction[/page/:page][/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '\d+',
                        'page' => '\d+'
                    ),
                    'defaults' => array(
                        'controller' => __NAMESPACE__ . '\\Controller\\Interaction',
                        'action' => 'index',
                        'page' => 1
                    ),
                ),
            ),
            'ticket' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/ticket[/page/:page][/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '\d+',
                        'page' => '\d+'
                    ),
                    'defaults' => array(
                        'controller' => __NAMESPACE__ . '\\Controller\\Ticket',
                        'action' => 'index',
                        'page' => 1
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type' => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'factories' => array(
            __NAMESPACE__ . '\\Controller\\Category' => __NAMESPACE__ . '\\Controller\\Factories\\Category',
            __NAMESPACE__ . '\\Controller\\Priority' => __NAMESPACE__ . '\\Controller\\Factories\\Priority',
            __NAMESPACE__ . '\\Controller\\Ticket' => __NAMESPACE__ . '\\Controller\\Factories\\Ticket',
            __NAMESPACE__ . '\\Controller\\Interaction' => __NAMESPACE__ . '\\Controller\\Factories\\Interaction',
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
            'zfcuser' => __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy'
        )
    ),
    'doctrine' => array(
        'eventmanager' => array(
            'orm_default' => array(
                'subscribers' => array(
                    'Gedmo\Timestampable\TimestampableListener',
                ),
            ),
        ),
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ),
            ),
        ),
    ),
    'data-fixture' => array(
        __NAMESPACE__ . '_fixture' => __DIR__ . '/../src/' . __NAMESPACE__ . '/Fixture',
    ),

    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(),
        ),
    ),
);
