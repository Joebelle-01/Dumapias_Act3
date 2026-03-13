<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// SIMPLE TEST ROUTES FIRST
$router->get('/test-get', function () {
    return response()->json(['message' => 'GET test works!']);
});

$router->post('/test-post', function () {
    return response()->json(['message' => 'POST test works!']);
});

// API Gateway routes for Site 1
$router->group(['prefix' => 'api/users1'], function () use ($router) {
    $router->get('/', 'User1Controller@index');
    $router->post('/', 'User1Controller@add');      // THIS IS THE MISSING ROUTE!
    $router->get('/{id}', 'User1Controller@show');
    $router->put('/{id}', 'User1Controller@update');
    $router->patch('/{id}', 'User1Controller@update');
    $router->delete('/{id}', 'User1Controller@delete');
});

// API Gateway routes for Site 2
$router->group(['prefix' => 'api/users2'], function () use ($router) {
    $router->get('/', 'User2Controller@index');
    $router->post('/', 'User2Controller@add');      // THIS IS THE MISSING ROUTE!
    $router->get('/{id}', 'User2Controller@show');
    $router->put('/{id}', 'User2Controller@update');
    $router->patch('/{id}', 'User2Controller@update');
    $router->delete('/{id}', 'User2Controller@delete');
});

// Route debugger
$router->get('/routes', function () use ($router) {
    $routes = [];
    foreach ($router->getRoutes() as $route) {
        $routes[] = [
            'method' => $route['method'],
            'uri' => $route['uri'],
        ];
    }
    return $routes;
});