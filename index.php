<?php

require_once __DIR__. "/vendor/autoload.php";

use Webonise\Routes\RegisterRoutes;
use Webonise\Routes\Http\Request;
use Webonise\Routes\Http\Routes;

$request = new Request();
$route = new Routes($request);
$routes = new RegisterRoutes($route);



print $routes->initRoute();
