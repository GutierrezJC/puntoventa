<?php 
 use Psr\Container\ContainerInterface;

 $container->set('base_datos',function(ContainerInterface $c ){
    $conf= $c->get('config_bd');
 

    $opc=[
        PDO :: ATTR_ERRMODE=> PDO :: ERRMODE_EXCEPTION,
        PDO :: ATTR_DEFAULT_FETCH_MODE => PDO :: FETCH_OBJ
    ];

    $dsn ="mysql:host=$conf->host; 
    dbname=$conf->db;
    charset=$conf->charset";
    //die es para morir la conexion 
    try{
    $con=new PDO( $dsn,$conf->user,$conf->passw,$opc);
    //die ("conectando a la base de datos");

    }
    catch(PDO_Exception $e){
    print ('Error ' . $e-> getMessage(). '<br>');
    //die ("Error contetadondeo a la base de datos"); 
    }
 return $con;
 });