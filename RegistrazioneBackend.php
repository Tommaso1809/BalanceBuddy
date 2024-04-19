<?php
include 'connectDB.php';

session_start();

$nome = $_POST['nome'];
$cognome = $_POST['cognome'];
$email = $_POST['email'];
$password = $_POST['password'];
$stringa = "Utente già registrato!";

$sanitized_name =  
    mysqli_real_escape_string($connect, $nome); 
      
$sanitized_cognome=  
    mysqli_real_escape_string($connect, $cognome); 

$sanitized_email=  
    mysqli_real_escape_string($connect, $email); 
    
$sanitized_password=  
    mysqli_real_escape_string($connect, $password);     

$passwordMD5 = md5($sanitized_password);

$sql = "SELECT email 
        FROM utente
        WHERE email = '$sanitized_email'";

$result=mysqli_query($connect,$sql);
$row=mysqli_num_rows($result);

if ($row == 1) {
    echo "<script language=\"JavaScript\">\n";
    echo "alert(\"" . $stringa . "\");\n";
    echo "</script>";
} else if ($row == 0) {
    $_SESSION['variabile di sessione'] = $email;

    $sql = "INSERT INTO utente (email, nome, cognome, password)
            VALUES ('$sanitized_email', '$sanitized_name', '$sanitized_cognome', '$passwordMD5');";

    $result=mysqli_query($connect,$sql);

    if ($result) {
          $sql = "INSERT INTO portafoglio(entrate, uscite, budget)
                VALUES (0, 0, 0);";
          $result=mysqli_query($connect,$sql);       

          $result=mysqli_query($connect,$sql);
          $latest_id =  mysqli_insert_id($connect);

          $sql="INSERT INTO possiede(utente,portafoglio)
                        VALUES('$sanitized_email',$latest_id)";

          $result=mysqli_query($connect,$sql);   
    }
    
     header("Location: home.php");
}

?>