<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Comic+Neue:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap" rel="stylesheet">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css'
            rel='stylesheet'>
        <link rel="stylesheet" href="styleHome.css">
        <title>Home</title>
    </head>
    <body>
        

        <span id="top_app">
           
                <h4 style="color:white;font-family: 'Comic Neue', cursive;font-size: 35px;">Saldo Attuale</h4>
            
        </span>

        <?php
             include '../Back-end/connectDB.php';

            session_start();

            $email=$_SESSION['variabile di sessione'];

            $sql="  SELECT portafoglio.entrate, portafoglio.uscite
                    FROM portafoglio
                    JOIN possiede
                    ON possiede.portafoglio=portafoglio.IDportafoglio
                    JOIN utente
                    ON possiede.utente=utente.email
                    WHERE possiede.utente='$email'";
            
            $result = mysqli_query($connect, $sql);

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);

                $entrate=$row['entrate'];
                $uscite=$row['uscite'];

                if($entrate>$uscite){

                    $differenza=$entrate-$uscite;
                }
                else{
                    $differenza=$uscite-$entrate;
                }

               

                echo '<p id="saldo">'.$differenza.' €'.'</p>';
               
            } else {
                echo "No rows found.";
            }

               
            echo '<table>';
                echo '<tr>';
                    echo '<th>Importo</th>';
                    echo '<th>Categoria</th>';
                    echo '<th>Data </th>';
                    echo '<th>Tipologia</th>';
                echo '</tr>';

                    $sql="SELECT movimento.categoria,movimento.dataInserimento,movimento.importo,movimento.tipologia
                    FROM movimento
                    JOIN ha 
                    ON movimento.IDmovimento=ha.movimento
                    JOIN portafoglio
                    ON portafoglio.IDportafoglio=ha.portafoglio
                    JOIN possiede
                    ON possiede.portafoglio=portafoglio.IDportafoglio
                    JOIN utente
                    ON utente.email=possiede.utente
                    WHERE possiede.utente='$email'";

                    $result = mysqli_query($connect, $sql);

                    while($row = mysqli_fetch_assoc($result)){
                        echo '<tr>';
                            echo '<td>'.$row['importo'].'</td>';
                            echo '<td>'.$row['categoria'].'</td>';
                            echo '<td>'.$row['dataInserimento'].'</td>';
                            echo '<td>'.$row['tipologia'].'</td>';
                        echo '</tr>';    
                        
                    }
           
               
               
        echo '</table>';  

        ?>

         



        <div class="navigation">
            <ul>
                <li class="list active" data-active="0">
                    <a href="#">
                        <span class="icon">
                            <i class="bx bx-home"></i>
                        </span>
                    </a>
                </li>
                <li class="list" data-active="1">
                    <a href="#">
                        <span class="icon">
                            <i class="bx bx-chat"></i>
                        </span>
                    </a>

                </li>
                <li class="list" data-active="2">
                    <a href="#">
                        <span class="icon">
                            <i class="bx bx-user"></i>
                        </span>
                    </a>

                </li>
                <li class="list" data-active="3">
                    <a href="#">
                        <span class="icon">
                            <i class="bx bxs-contact"></i>
                        </span>
                    </a>

                </li>
                <li class="list" data-active="4">
                    <a href="#">
                        <span class="icon">
                            <i class="bx bx-cog"></i>
                        </span>
                    </a>

                </li>
                <div class="active-tab"></div>
            </ul>
        </div>
        <script src="main.js"></script>
    </body>
</html>