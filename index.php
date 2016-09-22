<?php

require_once __DIR__. "/vendor/autoload.php";

use Webonise\Connectivity\DatabaseConnection;
use Webonise\Routes\RegisterRoutes;
use Webonise\Routes\Http\Request;
use Webonise\Routes\Http\Routes;

$options = [];
$db = new DatabaseConnection($options);
$request = new Request();
$route = new Routes($request);
$routes = new RegisterRoutes($route);

$dbh = $db->getConnection();

print $routes->initRoute();
