<?php

    include "connectDB.php";
    session_start();

    $categoria=$_POST['product-title'];
    $importo=$_POST['product-amount'];
    $tipologia=$_POST['type_amount'];

    $email= $_SESSION['variabile di sessione'];
  
    

    $Object = new DateTime();
    $Object->setTimezone(new DateTimeZone('Europe/Rome'));
    $DateAndTime = $Object->format("Y-m-d");

    $sql="INSERT INTO movimento(categoria,dataInserimento,importo,tipologia)
          VALUES ('$categoria','$DateAndTime','$importo','$tipologia')";


    if (mysqli_query($connect, $sql)) {

        
        

        $latest_id =  mysqli_insert_id($connect);
        
        $sql="SELECT portafoglio.IDportafoglio
                FROM portafoglio
                JOIN possiede
                ON possiede.portafoglio= portafoglio.IDportafoglio
                JOIN utente
                ON possiede.utente=utente.email
                WHERE utente.email='$email'";

        $result=mysqli_query($connect,$sql);
        
        $rowP=mysqli_fetch_assoc($result);

        $portafolgio=$rowP['IDportafoglio'];

        $sql="INSERT INTO ha(portafoglio,movimento)
              VALUES($portafolgio,$latest_id)";
        
        if(mysqli_query($connect,$sql)){
            echo 'ok';
        }

        $budget=$_SESSION['budget_sessione'];
        

        if(($_POST['type_amount'] =='entrata')){

            


            $entrata=$_SESSION['entrate_sessione'];

            $totale=$entrata+$importo;

            $_SESSION['entrate_sessione']=$totale;

            $sql="UPDATE portafoglio
            JOIN possiede
            ON possiede.portafoglio = portafoglio.IDportafoglio
            JOIN utente
            ON utente.email = possiede.utente
            SET portafoglio.entrate = '$totale'
            WHERE utente.email = '$email'";

            $result=mysqli_query($connect,$sql);
        }
        else if($_POST['type_amount'] =='uscita'){

                    
            $uscita=$_SESSION['uscite_sessione'];

            $totale=$uscita+$importo;

            $_SESSION['uscite_sessione']=$totale;

            $sql="UPDATE portafoglio
            JOIN possiede
            ON possiede.portafoglio = portafoglio.IDportafoglio
            JOIN utente
            ON utente.email = possiede.utente
            SET portafoglio.uscite = '$totale'
            WHERE utente.email = '$email'";

            $result=mysqli_query($connect,$sql);
        }
        

    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }


   

        header("Location:../Front-end/home.php");
    

    

?>