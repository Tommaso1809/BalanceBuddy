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
            <h3>Budget</h3>
            <p class="hide error" id="budget-error">
              Value cannot be empty or negative
            </p>
            <form action="../Back-end/setBudget.php" method="POST">
                <input
                type="number"
                id="total-amount"
                name="total-amount"
                placeholder="Budget Totale"
				step="any"
                />
                <button type="submit" class="submit" id="total-amount-button">Set Budget</button>
            </form>
          </div>

          <!-- Expenditure -->
          <div class="user-amount-container">
            <h3>Spese</h3>
            <p class="hide error" id="product-title-error">
              Values cannot be empty
            </p>

            <form action="../Back-end/addExpenses.php" method="POST">
            <input
              type="text"
              class="product-title"
              id="product-title"
              name="product-title"
              placeholder="Titolo movimento"
              step="any"
			  required
            />
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

                include "../Back-end/connectDB.php";
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
                <form action="..\Back-end\delete.php" method="POST">
                    <button style="background-color:red;border:0px;color:white;border-radius:5px;padding:2px;" type="submit" id="dBTN" name="dBTN" value="'.$row['IDmovimento'].'">Rimuovi</button>
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
          
      <canvas id="pie-chart" class="chart-resize"></canvas>
      
        <script>
      // Declare the data variables as global variables
      var entrate, uscite, budget;

      // Get the context of the canvas element
      var ctx = document.getElementById('pie-chart').getContext('2d');

      // Get the user's financial information using PHP
      <?php

          $email=$_SESSION['variabile di sessione'];

          $sql="SELECT portafoglio.entrate,portafoglio.budget
                FROM portafoglio
                JOIN possiede
                ON possiede.portafoglio=portafoglio.IDportafoglio
                JOIN utente
                ON utente.email=possiede.utente
                WHERE utente.email='$email'";

          $result=mysqli_query($connect,$sql);

          $row=mysqli_fetch_array($result);

          // Set the global variables
          echo 'entrate='.$row['entrate'].';';

          echo 'budget='.$row['budget'].';';
      ?>

      // Define the data labels and values for the pie chart
      var labels = ['Entrate', 'Budget'];
      var data = [entrate,budget];

      // Create a new pie chart with the data
      var chart = new Chart(ctx, {
        type: 'pie',
        data: {
          labels: labels,
          datasets: [{
            label: 'Grafico Entrate',
            data: data,
            backgroundColor: [
              'rgba(255, 99, 132, 0.2)',
              'rgba(54, 162, 235, 0.2)',
              'rgba(255, 206, 86, 0.2)'
            ],
            borderColor: [
              'rgba(255, 99, 132, 1)',
              'rgba(54, 162, 235, 1)',
              'rgba(255, 206, 86, 1)'
            ],
            borderWidth: 1
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
    <br>
    <canvas id="pie-chart_1" class="chart-resize"></canvas>
      
      <script>
    // Declare the data variables as global variables
    var entrate, uscite, budget;

    // Get the context of the canvas element
    var ctx = document.getElementById('pie-chart_1').getContext('2d');

    // Get the user's financial information using PHP
    <?php

        $email=$_SESSION['variabile di sessione'];

        $sql="SELECT portafoglio.uscite,portafoglio.budget
              FROM portafoglio
              JOIN possiede
              ON possiede.portafoglio=portafoglio.IDportafoglio
              JOIN utente
              ON utente.email=possiede.utente
              WHERE utente.email='$email'";

        $result=mysqli_query($connect,$sql);

        $row=mysqli_fetch_array($result);

        // Set the global variables
        echo 'uscite='.$row['uscite'].';';
        echo 'budget='.$row['budget'].';';
    ?>

    // Define the data labels and values for the pie chart
    var labels = ['Uscite', 'Budget'];
    var data = [uscite,budget];

    // Create a new pie chart with the data
    var chart = new Chart(ctx, {
      type: 'pie',
      data: {
        labels: labels,
        datasets: [{
          label: 'Grafico Uscite',
          data: data,
          backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)'
          ],
          borderColor: [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)'
          ],
          borderWidth: 1
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

  
  </body>
</html>