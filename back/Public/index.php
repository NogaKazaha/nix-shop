<?php
require __DIR__ . "/../App/bootstrap/bootstrap.php";

use Controllers\UserController;
use Database\DbConnection;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);
switch ($uri[1]) {
  case 'user':
    $userId = null;
    if (isset($uri[2])) {
      $userId = (int) $uri[2];
    }
    $requestMethod = $_SERVER["REQUEST_METHOD"];
    $controller = new UserController(DbConnection::getDB(), $requestMethod, $userId);
    $controller->processRequest();
    break;
  default:
    header("HTTP/1.1 404 Not Found");
    exit();
}