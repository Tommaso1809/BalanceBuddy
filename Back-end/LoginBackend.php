<?php

    include 'connectDB.php';
    session_start();

    $email= $_POST['email'];
    $password=$_POST['password'];
    $stringa="Email e password errati!";

    $passwordMD5=md5($password);

    $sql = "SELECT email, password FROM utente WHERE email = ? AND password = ?";
    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $email, $passwordMD5);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    $row = mysqli_stmt_num_rows($stmt);

    if ($row == 1) {
        $_SESSION['variabile di sessione'] = $email;
        echo "Utente Trovato";
        header("Location:..\Front-end\home.php");
    } else {
        echo "<script language=\"JavaScript\">\n";
        echo "alert(\"" . $stringa . "\");\n";
        echo "</script>";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($connect);
?>
