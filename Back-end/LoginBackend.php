<?php

    include 'connectDB.php';
    session_start();

    $email= $_POST['email'];
    $password=$_POST['password'];
    $stringa="Email e password errati!";

    $passwordMD5=md5($password);

    $sql="SELECT email, password 
          FROM utente
          WHERE email = '$email' AND password='$passwordMD5'";

    $result=mysqli_query($connect,$sql);
    $_SESSION['sessione']=

    $row=mysqli_num_rows( $result );

    if($row==1){

      $_SESSION['variabile di sessione']=$email;
        echo "Utente Trovato";
        header("Location:..\Front-end\home.php");
    }
    else{
   
		echo "<script language=\"JavaScript\">\n";
		echo "alert(\"" . $stringa . "\");\n";
		echo "</script>";
		
		

    }
?>
