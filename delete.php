<?php

    session_start();
    include 'connectDB.php';

        $email=$_SESSION['variabile di sessione'];

        $id = $_POST['dBTN'];

        $sql="DELETE FROM ha WHERE movimento='$id'";

        $result=mysqli_query($connect,$sql);

        $sql="SELECT movimento.tipologia,movimento.importo
              FROM movimento
              WHERE IDmovimento='$id'";

        $result=mysqli_query($connect,$sql);   
        
        $row=mysqli_fetch_array($result);

        if($row['tipologia']=='entrata'){

            $entrata=$_SESSION['entrate_sessione'];

            $importo=$row['importo'];

            $totale=$entrata-$importo;

            $_SESSION['entrate_sessione']=$totale;

            $sql="UPDATE portafoglio
            JOIN possiede
            ON possiede.portafoglio = portafoglio.IDportafoglio
            JOIN utente
            ON utente.email = possiede.utente
            SET portafoglio.entrate = '$totale'
            WHERE utente.email = '$email'"  ;


            $result=mysqli_query($connect,$sql);   
        
            
        }
        else if($row['tipologia']=='uscita'){

            $uscita=$_SESSION['uscite_sessione'];

            $importo=$row['importo'];

            $totale=$uscita-$importo;

            $_SESSION['uscite_sessione']=$totale;

            $sql="UPDATE portafoglio
            JOIN possiede
            ON possiede.portafoglio = portafoglio.IDportafoglio
            JOIN utente
            ON utente.email = possiede.utente
            SET portafoglio.uscite = '$totale'
            WHERE utente.email = '$email'"  ;


            $result=mysqli_query($connect,$sql);   
        
            
        }

        $sql="DELETE FROM movimento WHERE IDmovimento='$id'";
        $result=mysqli_query($connect,$sql);

        
        header('Location:home.php');
    
		 mysqli_close($connect);
?>