<?php
require_once __DIR__ . '/../src/AutoLoader.php';

use CoolBlue\AutoLoader;
use CoolBlue\Services\ConfigurationReader;
use CoolBlue\Services\Router\Router;
use CoolBlue\Request\Request;


$autoloader = new AutoLoader();

$autoloader->addPrefix('CoolBlue\\',  dirname(__FILE__) . '/../src');
$autoloader->addPrefix('CoolBlue\\',  dirname(__FILE__) . '/../Tests');

$autoloader->register();


$routerConfig = ConfigurationReader::readFromJsonFile(__DIR__.'/../Resources/Config/routing.json');
$router = new Router($routerConfig);
$router->dispatchRequest(new Request);

