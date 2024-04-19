<?php
	include "connectDB.php";
    
    $email=$_POST['email'];
    $password=$_POST['password'];
    
    $passwordMD5=md5($password);
    
    $sql="UPDATE utente
    	 SET password='$passwordMD5'
         WHERE email='$email'";
    $result=mysqli_query($connect,$sql);
    
    if($result){
    	header("Location:index.html");
    }


?>