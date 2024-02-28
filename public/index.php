<?php

require_once "./vendor/autoload.php";

use Leli\HttpNotFoundException;
use Leli\Route;
use Leli\Router;

$router = new Router();

$router->get("/", function () {
    return "GET ok";
});

$router->post("/", function () {
    return "POST ok";
});

try {
    $route = $router->resolve($_SERVER["REQUEST_URI"], $_SERVER["REQUEST_METHOD"]);
    $action = $route->action();
    print($action());
} catch (HttpNotFoundException $e) {
    print("Not found");
    http_response_code(404);
}
