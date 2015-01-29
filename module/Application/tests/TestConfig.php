<?php

return array(
    //Configuração do módulo para ser Testado
    //Pode colocar módulos que faz parte do módulo que será testado
    'modules' => array(
        'DoctrineModule',
        'DoctrineORMModule',
        'Application'
    ),
    'module_listener_options' => array(
        'config_glob_paths'    => array(
            '../../../config/autoload/{,*.}{global,local}.php',
        ),
        'module_paths' => array(
            './module',
            './vendor',
        ),
    ),
    //Configuração para não carregar as entidades dos módulos
    'not_load_entity' => array(
    )
);
