<?php

    include "connectDB.php";
    session_start();

    $categoria=$_POST['product-title'];
    $importo=$_POST['product-amount'];

    $email= $_SESSION['variabile di sessione'];

    $Object = new DateTime();
    $Object->setTimezone(new DateTimeZone('Europe/Rome'));
    $DateAndTime = $Object->format("Y-m-d");

    $sql="INSERT INTO movimento(categoria,dataInserimento,importo)
          VALUES ('$categoria','$DateAndTime','$importo')";

    $result=mysqli_query($connect,$sql);

    if($result){

        header("Location:../Front-end/home.php");
    }

    

?>