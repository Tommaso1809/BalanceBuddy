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

    $result=mysqli_query($connect,$sql);

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
            //header("Location: homepage.html");
        }
    }
    else{
   
		
		

    }


?>