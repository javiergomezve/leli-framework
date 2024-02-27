<?php

namespace Leli\Tests;

use Leli\HttpMethod;
use Leli\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    public function test_resolve_basic_route_with_callback_action()
    {
        $uri = "/test";
        $action = fn() => "test";

        $router = new Router();
        $router->get($uri, $action);

        $this->assertEquals($action, $router->resolve($uri, HttpMethod::GET->value));
    }

    public function test_resolve_multiple_basic_routes_with_callback_action()
    {
        $routes = [
            "/test" => fn() => "test",
            "/foo" => fn() => "foo",
            "/bar" => fn() => "bar",
            "/long/nested/route" => fn() => "long nested route",
        ];

        $router = new Router();
        foreach ($routes as $uri => $action) {
            $router->get($uri, $action);
        }

        foreach ($routes as $uri => $action) {
            $this->assertEquals($action, $router->resolve($uri, HttpMethod::GET->value));
        }
    }

    public function test_resolve_multiple_basic_routes_with_callback_action_for_different_http_methods()
    {
        $routes = [
            [HttpMethod::GET->value, "/test", fn() => "get"],
            [HttpMethod::POST->value, "/test", fn() => "post"],
            [HttpMethod::PUT->value, "/test", fn() => "put"],
            [HttpMethod::PATCH->value, "/test", fn() => "patch"],
            [HttpMethod::DELETE->value, "/test", fn() => "delete"],

            [HttpMethod::GET->value, "/random/get", fn() => "get"],
            [HttpMethod::POST->value, "/random/nested/post", fn() => "post"],
            [HttpMethod::PUT->value, "/put/random/route", fn() => "put"],
            [HttpMethod::PATCH->value, "/some/patch/route", fn() => "patch"],
            [HttpMethod::DELETE->value, "/d", fn() => "delete"],
        ];

        $router = new Router();

        foreach ($routes as [$method, $uri, $action]) {
            $router->{strtolower($method)}($uri, $action);
        }

        foreach ($routes as [$method, $uri, $action]) {
            $this->assertEquals($action, $router->resolve($uri, $method));
        }
    }
}
