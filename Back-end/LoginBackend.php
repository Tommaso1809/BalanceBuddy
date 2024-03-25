<?php

    include 'connectDB.php';

    $email= $_POST['email'];
    $password=$_POST['password'];
    $stringa="Email e password errati!";

    $passwordMD5=md5($password);

    $sql="SELECT email, password 
          FROM utente
          WHERE email = '$email' AND password='$passwordMD5'";

    $result=mysqli_query($connect,$sql);

    $row=mysqli_num_rows( $result );

    if($row==1){
        echo "Utente Trovato";
    }
    else{
   
		echo "<script language=\"JavaScript\">\n";
		echo "alert(\"" . $stringa . "\");\n";
		echo "</script>";
		
		

    }
?>
