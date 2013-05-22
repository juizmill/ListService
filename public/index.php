<?php

//Config for development
#ini_set('display_errors', true);
#error_reporting(E_ALL | E_STRICT);

//Este IF verifica se a URL termina com uma BARRA, caso ela termine a BARRA é removida.
//Assim evitando o erro 404.
/*
if(preg_match("/^(.*)\/$/", $_SERVER['REQUEST_URI'])){
  $uri = substr_replace($_SERVER['REQUEST_URI'],'', -1, strlen($_SERVER['REQUEST_URI']));
  header("Location: http://{$_SERVER['HTTP_HOST']}{$uri}");
  exit();
}
*/

$host = $_SERVER['REQUEST_URI'];
if ($host == '/' || $host == '' ){
    header('Location: http://'.$_SERVER['SERVER_NAME'].'/auth');
    exit();

}

date_default_timezone_set('America/Campo_Grande');

/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
chdir(dirname(__DIR__));

// Setup autoloading
require 'init_autoloader.php';

// Run the application!
Zend\Mvc\Application::init(require 'config/application.config.php')->run();