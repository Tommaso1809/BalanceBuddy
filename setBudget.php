<?php
    include "connectDB.php";
    session_start();

    $budget=$_POST['total-amount'];
    $email= $_SESSION['variabile di sessione'];

    $sql="  UPDATE portafoglio
            SET portafoglio.budget = '$budget'
            WHERE portafoglio.IDportafoglio = (
            SELECT possiede.portafoglio
            FROM possiede
            INNER JOIN utente
            ON possiede.utente = utente.email
            WHERE utente.email = '$email'
            )";
    $result=mysqli_query($connect,$sql);

    if($result){

        header("Location:home.php");
    }



?>