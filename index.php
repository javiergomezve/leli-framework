<?php

require "./Router.php";

$router = new Router();

$router->get("/", function () {
    return "GET ok";
});

$router->post("/", function () {
    return "POST ok";
});

try {
    $action = $router->resolve();
    print($action());
} catch (HttpNotFoundException $e) {
    print("Not found");
    http_response_code(404);
}
