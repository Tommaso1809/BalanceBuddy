<?php
     include 'connectDB.php';

     session_start();

    $nome=$_POST['nome'];
    $cognome=$_POST['cognome'];
    $email= $_POST['email'];
    $password=$_POST['password'];
    $stringa="Utente già registrato!";

    $passwordMD5=md5($password);

    $sql="SELECT email 
          FROM utente
          WHERE email = '$email'";

    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $email, $passwordMD5);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    $row=mysqli_num_rows( $result );

    if($row==1){
        echo "<script language=\"JavaScript\">\n";
		echo "alert(\"" . $stringa . "\");\n";
		echo "</script>";
		
    }
    else if($row==0){

        $_SESSION['variabile di sessione']=$email;

        $sql="INSERT INTO utente (email,nome,cognome,password)
              VALUES('$email','$nome','$cognome','$passwordMD5')";

        $result=mysqli_query($connect,$sql);

        if($result){

            $sql="INSERT INTO portafoglio(entrate,uscite,budget)
                    VALUES(0,0,0)";

            $result=mysqli_query($connect,$sql);
            $latest_id =  mysqli_insert_id($connect);

            $sql="INSERT INTO possiede(utente,portafoglio)
                    VALUES('$email',$latest_id)";
            
            $result=mysqli_query($connect,$sql);

            header("Location:..\Front-end\home.php");
        }
    }
    
	mysqli_stmt_close($stmt);
    mysqli_close($connect);

?>