<?php
    $con = new mysqli('localhost:3310', 'root', 'root', 'sa');

    if($con->connect_error){
        echo "Erro: ".$con->connect_error;
    }

?>