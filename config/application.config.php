<?php

return array(
    'modules' => array(
        'DoctrineModule',
        'DoctrineORMModule',
        'DoctrineDataFixtureModule',
        #'LSAuth',
        'LSBase',
        'LSCategoryticket',
        'LSInteraction',
        'LSPriority',
        'LSTicket',
        'LSTypeuser',
        'LSUser',
        'LSHome',
    ),
    'module_listener_options' => array(
        'config_glob_paths' => array(
            'config/autoload/{,*.}{global,local}.php',
        ),
        'module_paths' => array(
            './module',
            './vendor',
        ),
    ),
);
