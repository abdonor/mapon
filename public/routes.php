<?php
ini_set('error_reporting', E_ALL);
ini_set("display_errors", 1);

require_once  '../vendor/autoload.php';
require_once 'GetRouteService.php';

session_start();
if (!isset($_SESSION['access_token'])) {
    header('Location: index.php');
}

$route = new GetRouteService();

header('Content-Type: application/json');

echo json_encode($route->getRoute() , true);