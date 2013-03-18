<?php

namespace LSRelatorio;

return array(
    'router' => array(
        'routes' => array(
            'relatorio' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/relatorio',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'LSRelatorio\Controller\Relatorio',
                        'action' => 'index',
                    ),
                ),
            ),
        )
    ),
    'controllers' => array(
        'invokables' => array(
            'LSRelatorio\Controller\Relatorio' => 'LSRelatorio\Controller\RelatorioController',
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../../LSBase/view/layout/layout.phtml',
            'error/404' => __DIR__ . '/../../LSBase/view/error/404.phtml',
            'error/index' => __DIR__ . '/../../LSBase/view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    )
);
