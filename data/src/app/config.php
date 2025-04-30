<?php
$container -> set('config_bd', function(){
    return(object)[

        "host"=> "db",
        "db"=> "ventas",
        "user"=> "root",
        "passw"=> "12345",
        "charset"=>"utf8mb4",
    ];
}

);

?>