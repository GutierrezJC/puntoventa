<?php
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->get('/api/negocio', function ($request, $response, $args) {
    $response->getBody()->write("Capa de negocio funcionando correctamente");
    return $response->withHeader('Content-Type', 'text/plain');
});
