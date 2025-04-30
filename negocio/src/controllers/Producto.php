<?php 
namespace App\controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Container\ContainerInterface;

use PDO;

class Producto {

    protected $container;

   
    public function __construct(ContainerInterface $container) {
        $this->container = $container; 
    }
    #/ Método para crear un nuevo producto request la consulta,args agumentos
     //401 no cntra ni usuario// 403 no tiene derecho //error de usuario inician con 4 // generando un conflico como crear doble id o algo asi 
    
    #/ Método para crear un nuevo producto request la consulta,args agumentos
     //401 no cntra ni usuario// 403 no tiene derecho //error de usuario inician con 4 // generando un conflico como crear doble id o algo asi 
     public function read(Request $request, Response $response, $args)
     {
         $sql = "SELECT * FROM productos";
      
         //si tiene un arigumento id en la url entonces se le agrega a la consulta sql
         if(isset($args['id'])){
            $sql.=" WHERE id = :id;";
         }
         $sql.=" LIMIT 0,5;";

         $con = $this->container->get('base_datos');
         $query = $con->prepare($sql);//el query recibe la consulta sql 



         if(isset($args["id"])){
            $query->execute(["id"=>$args["id"]]);
         }else{
            $query->execute();
         }
       
         $res = $query->fetchAll();
     
 
         
 
         $status= $query->rowCount() > 0 ? 200 : 204 ;
 
         $response->getBody()->write(json_encode($res));
         return $response
             ->withHeader('Content-Type', 'application/json')
             ->withStatus($status);
 
     }

        // public function create(Request $request, Response $response, $args)
        // {
        //     $sql = "INSERT INTO productos (nombre, precio) VALUES (:nombre, :precio);";
        //     $con = $this->container->get('base_datos');
        //     $query = $con->prepare($sql);//el query recibe la consulta sql 
        //     $query->execute([
        //         "nombre"=>$request->getParsedBody()["nombre"],
        //         "precio"=>$request->getParsedBody()["precio"]
        //     ]);
        //     $res = $query->fetchAll();
        //     $status= $query->rowCount() > 0 ? 200 : 204 ;
    
        //     $response->getBody()->write(json_encode($res));
        //     return $response
        //         ->withHeader('Content-Type', 'application/json')
        //         ->withStatus($status);
    
        // }

        public function create(Request $request, Response $response, $args)
        {
            $body=json_decode($request->getBody() );
            $sql ="INSERT INTO productos (
                id,
                codigo_producto,
                id_categoria_producto,
                descripcion_producto,
                precio_compra_producto,
                precio_venta_producto,
                utilidad,
                stock_producto,
                minimo_stock_producto,
                ventas_producto,
                fecha_creacion_producto,
                fecha_actualizacion_producto
            ) VALUES (
                99, -- id
                10002, -- codigo_producto
                5, -- id_categoria_producto
                'chocolate', -- descripcion_producto
                2.0, -- precio_compra_producto
                3.5, -- precio_venta_producto
                1.5, -- utilidad
                20, -- stock_producto
                10, -- minimo_stock_producto
                8, -- ventas_producto
                '2025-04-09 12:00:00', -- fecha_creacion_producto
                NULL -- fecha_actualizacion_producto
            )";
            $res=$body;
            $status= 200;
            $con = $this->container->get('base_datos');
            $query = $con->prepare($sql);//el query recibe la consulta sql 

            
            $response->getBody()->write(json_encode($res));
         return $response
             ->withHeader('Content-Type', 'application/json')
             ->withStatus($status);

        }


    }