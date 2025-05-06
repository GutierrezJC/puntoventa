<?php 
namespace App\controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Container\ContainerInterface;

use PDO;

class Artefacto {

    protected $container;

    public function __construct(ContainerInterface $container) {
        $this->container = $container; 
    }

    // Método para leer artefactos
    public function read(Request $request, Response $response, $args)
    {
        $sql = "SELECT * FROM artefacto";

        if (isset($args['id'])) {
            $sql .= " WHERE id = :id";
        }

        $con = $this->container->get('base_datos');
        $query = $con->prepare($sql);

        if (isset($args['id'])) {
            $query->execute(['id' => $args['id']]);
        } else {
            $query->execute();
        }

        $res = $query->fetchAll();
        $status = $query->rowCount() > 0 ? 200 : 204;

        $response->getBody()->write(json_encode($res));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($status);
    }

    // Método para crear un nuevo artefacto
    public function create(Request $request, Response $response, $args)
    {
        $body = json_decode($request->getBody());

        $campos = "";
        $params = "";
        foreach ($body as $key => $value) {
            $campos .= $key . ", ";
            $params .= ":" . $key . ", ";
        }
        $campos = rtrim($campos, ", ");
        $params = rtrim($params, ", ");

        $sql = "INSERT INTO artefacto ($campos) VALUES ($params)";

        $con = $this->container->get('base_datos');
        $query = $con->prepare($sql);

        foreach ($body as $key => $value) {
            $TIPO = gettype($value) == "integer" ? PDO::PARAM_INT : PDO::PARAM_STR;
            $query->bindValue($key, $value, $TIPO);
        }

        try {
            $query->execute();
            $status = 201;
        } catch (\PDOException $e) {
            $status = $e->getCode() == 23000 ? 409 : 500;
        }

        return $response->withStatus($status);
    }

    // Método para actualizar un artefacto
    public function update(Request $request, Response $response, $args)
    {
        $body = json_decode($request->getBody());

        if (isset($body->id)) {
            unset($body->id);
        }

        $sql = "UPDATE artefacto SET ";
        foreach ($body as $key => $value) {
            $sql .= "$key = :$key, ";
        }
        $sql = rtrim($sql, ", ");
        $sql .= " WHERE id = :id";

        $con = $this->container->get('base_datos');
        $query = $con->prepare($sql);

        foreach ($body as $key => $value) {
            $TIPO = gettype($value) == "integer" ? PDO::PARAM_INT : PDO::PARAM_STR;
            $query->bindValue($key, $value, $TIPO);
        }
        $query->bindValue("id", $args['id'], PDO::PARAM_INT);

        $query->execute();
        $status = $query->rowCount() > 0 ? 200 : 204;

        return $response->withStatus($status);
    }

    // Método para eliminar un artefacto
    public function delete(Request $request, Response $response, $args)
    {
        $sql = "DELETE FROM artefacto WHERE id = :id";

        $con = $this->container->get('base_datos');
        $query = $con->prepare($sql);
        $query->bindValue('id', $args['id'], PDO::PARAM_INT);
        $query->execute();

        $status = $query->rowCount() > 0 ? 200 : 204;

        return $response->withStatus($status);
    }
}