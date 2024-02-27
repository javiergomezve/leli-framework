<?php

require_once "../vendor/autoload.php";

use Leli\HttpNotFoundException;
use Leli\Router;

$router = new Router();

$router->get("/", function () {
    return "GET ok";
});

$router->post("/", function () {
    return "POST ok";
});

try {
    $action = $router->resolve($_SERVER["REQUEST_URI"], $_SERVER["REQUEST_METHOD"]);
    print($action());
} catch (HttpNotFoundException $e) {
    print("Not found");
    http_response_code(404);
}
