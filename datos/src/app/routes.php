<?php 
namespace App\controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
    use Slim\Routing\RoutecollectorProxy;

$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Hello world!");
    return $response;
});

#aqui voy agragardo los endpoints de la api o rutas de la api 
$app->group('/api',function(RoutecollectorProxy $api){
    $api->group('/producto', function(RoutecollectorProxy $producto){

        $producto->get('/read[/{id}]',Producto::class . ":read");
        $producto->post('',Producto::class . ":create");
        $producto->put('/update[/{id}]',Producto::class . ":update");#el metodo que esta en la clase producto
        $producto->delete('/delete/{id}',Producto::class . ":delete");#el metodo que esta en la clase producto3
        $producto->get ('/filtrar',Producto::class . ":filtrar");#el metodo que esta en la clase producto3

    });
});




$app->get('/producto', function (Request $request, Response $response, $args) {
    $response->getBody()->write("acediendo a product!");
    return $response;
});



