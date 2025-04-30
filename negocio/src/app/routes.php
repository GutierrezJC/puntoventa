<?php 
namespace App\controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
    use Slim\Routing\RoutecollectorProxy;

$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Hello world!");
    return $response;
});


$app->group('/api',function(RoutecollectorProxy $api){
    $api->group('/producto', function(RoutecollectorProxy $producto){
        $producto->get('/read[/{id}]',Producto::class . ":read");
        $producto->post('/create',Producto::class . ":create");

    });
});




$app->get('/producto', function (Request $request, Response $response, $args) {
    $response->getBody()->write("acediendo a product!");
    return $response;
});



