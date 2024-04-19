<?php

include 'connectDB.php';
session_start();

$email = $_POST['email'];
$password = $_POST['password'];
$stringa = "Email e password errati!";

$sanitized_email =  
    mysqli_real_escape_string($connect, $email); 
      
$sanitized_password =  
    mysqli_real_escape_string($connect, $password); 

$passwordMD5 = md5($sanitized_password);

$sql="SELECT email,password
	FROM utente
    WHERE email='$sanitized_email' AND password='$passwordMD5'";

$result=mysqli_query($connect,$sql);
$row=mysqli_num_rows($result);

    if ($row == 1) {
        $_SESSION['variabile di sessione'] = $email;    
        echo "Utente Trovato";
        header("Location:home.php");

    } 
    else if ($row==0){	
        header("Location:index.html");
    }


mysqli_close($connect);

?>