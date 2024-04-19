<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Budget App</title>
    <!-- Font Awesome Icons -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
    />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Google Fonts -->
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap"
      rel="stylesheet"
    />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 
    <link rel="icon" type="image/x-icon" href="favicon.png">
    <!-- Stylesheet -->
    <link rel="stylesheet" href="styleHome.css" />
  </head>
  <body>
    <div class="wrapper">
      <div class="container">
        <div class="sub-container">
          <!-- Budget -->
          <div class="total-amount-container">
            <h3 style="font-size:25px;"><b>Budget</b></h3>
            <p class="hide error" id="budget-error">
              Value cannot be empty or negative
            </p>
            <form action="setBudget.php" method="POST">
                <input
                type="number"
                id="total-amount"
                name="total-amount"
                placeholder="Budget Totale"
				step="any"
                required
                />
                <button type="submit" class="submit" id="total-amount-button">Set Budget</button>
            </form>
          </div>

          <!-- Expenditure -->
          <div class="user-amount-container">
            <h3 style="font-size:25px;"><b>Spese</b></h3>
            <p class="hide error" id="product-title-error">
              Values cannot be empty
            </p>

            <form action="addExpenses.php" method="POST">
            <select id="product-title" name="product-title">
              <option value="Alimenti">Alimenti</option>
              <option value="Casa">Casa</option>
              <option value="Lavoro">Lavoro</option>
              <option value="Shopping">Shopping</option>
              <option value="Trasporto">Trasporto</option>
              <option value="Parcheggio">Parcheggio</option>
              <option value="Benzina">Benzina</option>
              <option value="Sport">Sport</option>
              <option value="Altro">Altro</option>
            </select><br>
            <input
              type="number"
              id="product-amount"
              name="product-amount"
              placeholder="Importo"
              step="any"
			  required
            />
            <select id="type_amount" name="type_amount">
              <option value="entrata">entrata</option>
              <option value="uscita">uscita</option>
            </select><br>
            <button type="submit" class="submit" id="check-amount">Calcolo Spesa</button>
            </form>
          </div>
        </div>
        <!-- Output -->
        <div class="output-container flex-space">
          <div>
            <p>Budget</p>
            <?php

                include "connectDB.php";
                session_start();

                $email=$_SESSION['variabile di sessione'];
                

                $sql="SELECT portafoglio.budget
                FROM portafoglio
                JOIN possiede
                ON possiede.portafoglio=portafoglio.IDportafoglio
                JOIN utente
                ON utente.email=possiede.utente
                WHERE utente.email='$email'";

                $result=mysqli_query($connect,$sql);

                $row=mysqli_fetch_array($result);

                $_SESSION['budget_sessione']=$row['budget'];

                echo '<span id="amount">'.$row['budget'].'</span>';

            ?>
            
          </div>
           <div>
            <p>Saldo Attuale</p>
            <?php

                include "connectDB.php";
                session_start();

                $email=$_SESSION['variabile di sessione'];
                

                $sql="SELECT portafoglio.entrate,portafoglio.uscite
                FROM portafoglio
                JOIN possiede
                ON possiede.portafoglio=portafoglio.IDportafoglio
                JOIN utente
                ON utente.email=possiede.utente
                WHERE utente.email='$email'";

                $result=mysqli_query($connect,$sql);

                $row=mysqli_fetch_array($result);

                $_SESSION['budget_sessione']=$row['budget'];
              
                	 $saldo_attuale=$row['entrate']-$row['uscite'];


                echo '<span id="amount">'.$saldo_attuale.'</span>';

            ?>
            
          </div>
          <div>
            <p>Spese</p>
            <?php
                $email=$_SESSION['variabile di sessione'];

                $sql="SELECT portafoglio.uscite
                FROM portafoglio
                JOIN possiede
                ON possiede.portafoglio=portafoglio.IDportafoglio
                JOIN utente
                ON possiede.utente=utente.email
                WHERE utente.email='$email'";

                $result=mysqli_query($connect,$sql);

                $row=mysqli_fetch_array($result);

                $_SESSION['uscite_sessione']=$row['uscite'];

                echo '<span id="expenditure-value">'.$row['uscite'].'</span>';

            ?>
            
          </div>
          <div>
            <p>Entrate</p>
            <?php
                $email=$_SESSION['variabile di sessione'];

                $sql="SELECT portafoglio.entrate
                FROM portafoglio
                JOIN possiede
                ON possiede.portafoglio=portafoglio.IDportafoglio
                JOIN utente
                ON possiede.utente=utente.email
                WHERE utente.email='$email'";

                $result=mysqli_query($connect,$sql);

                $row=mysqli_fetch_array($result);

                $_SESSION['entrate_sessione']=$row['entrate'];

                echo '<span id="id="balance-amount">'.$row['entrate'].'</span>';

            ?>
           
          </div>
        </div>
      </div>
      <!-- List -->
      <div class="list">
        <h3>Lista Movimenti</h3>
        <div class="list-container" id="list">

        <?php
           
           $email=$_SESSION['variabile di sessione'];

            $sql="SELECT movimento.categoria,movimento.importo,movimento.dataInserimento,movimento.tipologia,movimento.IDmovimento
            FROM movimento
            JOIN ha
            ON ha.movimento=movimento.IDmovimento
            JOIN portafoglio
            ON portafoglio.IDportafoglio=ha.portafoglio
            JOIN possiede
            ON possiede.portafoglio=portafoglio.IDportafoglio
            JOIN utente
            ON utente.email=possiede.utente
            WHERE utente.email='$email'";

            $result=mysqli_query($connect,$sql);

            $budget=$_SESSION['budget_sessione'];
            $stringa='Budget Superato';

            echo '<table style="width:100%;border-collapse:collapse;">';
            echo '<tr>';
              echo '<th>Titolo</th>';
              echo '<th>Importo</th>';
              echo '<th>Data</th>';
              echo '<th>Tipologia</th>';
              echo '<th></th>';
            echo '</tr>';  
              
            while($row=mysqli_fetch_array($result)){

            
              echo '<tr>';
              echo '<td style="text-align:center;">'.$row['categoria'].'</td>';
              echo '<td style="text-align:center;">'.$row['importo'].'€ '.'</td>';
              echo '<td style="text-align:center;">'.$row['dataInserimento'].'</td>';
              echo '<td style="text-align:center;">'.$row['tipologia'].'</td>';
              echo '<td>
                <form action="delete.php" method="POST">
                    <button style="font-size:36px;border:0px;color:black;background-color:white;border-radius:5px;padding:2px;" type="submit" id="dBTN" name="dBTN" value="'.$row['IDmovimento'].'"><i class="fa fa-trash-o"></i></button>
                 </form>    
               </td>';
              echo '</tr>';
            }

            echo '</table>';


        ?>
        </div>
      </div>
    </div>
        <!-- Script -->
      	<script src="script.js"></script>

<?php
  $email=$_SESSION['variabile di sessione'];
  $sql = "SELECT categoria, SUM(importo) as totale
          FROM movimento
          JOIN ha
          ON ha.movimento=movimento.IDmovimento
          JOIN portafoglio
          ON portafoglio.IDportafoglio=ha.portafoglio
          JOIN possiede
          ON possiede.portafoglio=portafoglio.IDportafoglio
          JOIN utente
          ON utente.email=possiede.utente
          WHERE utente.email='$email'
          GROUP BY categoria";
  $result = mysqli_query($connect,$sql);
  $data = array();
  if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
          $data[$row["categoria"]] = $row["totale"];
      }
  } else {
      echo "Nessun risultato trovato";
  }
  $connect->close();
?>

<canvas id="istogramma" class="size" width="45%" height="31%"></canvas>
<script>
  var data = <?php echo json_encode($data);?>;
  var ctx = document.getElementById('istogramma').getContext('2d');
  var colors = ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)', 'rgba(75, 192, 192, 0.2)', 'rgba(153, 102, 255, 0.2)', 'rgba(255, 159, 64, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)','rgba(172, 199, 145)'];
  var categoryCount = {};
  for (var category in data) {
    if (!categoryCount[category]) {
      categoryCount[category] = 1;
    }
  }
  var categoryColors = Object.keys(categoryCount).map((key, index) => colors[index % colors.length]);
  var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
          labels: Object.keys(data),
          datasets: [{
              label: "Istogramma",
              data: Object.values(data),
              backgroundColor: categoryColors,
              borderColor: categoryColors,
              borderWidth: 1,
              barThickness: 25
          }]
      },
      options: {
          scales: {
              y: {
                  beginAtZero: true
              }
          }
      }
  });
</script>
<center>
  <div style="background-color:#587ef4;height:95px;">
   
          <h3 style="color:white;text-align:center;float:center;padding-top:10px;">Sviluppato da </h3>
          <p style="color:white;font-size:14px;padding-top:5px;">Tommaso Polvere -
             Alberto Coscetti -
             Rayan Marzouki</p>
  </div>
   
   </center>
  </body>
</html>