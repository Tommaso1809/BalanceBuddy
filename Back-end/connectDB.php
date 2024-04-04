<?php

    $serverName="localhost";
    $username="root";
    $password="";
    $dbName="balancebuddy_db";

    $connect=mysqli_connect($serverName,$username,$password,$dbName);

    if(!$connect){
        echo "Errore nella connessione al Database";
    }

?>