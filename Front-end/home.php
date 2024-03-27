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
    <!-- Google Fonts -->
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap"
      rel="stylesheet"
    />
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
              placeholder="Titolo del prodotto"
            />
            <input
              type="number"
              id="product-amount"
              name="product-amount"
              placeholder="Importo del prodotto"
            />
            <button type="submit" class="submit" id="check-amount">Check Amount</button>
            </form>
          </div>
        </div>
        <!-- Output -->
        <div class="output-container flex-space">
          <div>
            <p>Total Budget</p>
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
            <span id="expenditure-value">0</span>
          </div>
          <div>
            <p>Bilancio</p>
            <span id="balance-amount">0</span>
          </div>
        </div>
      </div>
      <!-- List -->
      <div class="list">
        <h3>Lista Spese</h3>
        <div class="list-container" id="list">

        <?php
           
           $email=$_SESSION['variabile di sessione'];

            $sql="SELECT movimento.categoria,movimento.importo,movimento.dataInserimento
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

            while($row=mysqli_fetch_array($result)){

              if($row['importo']>$budget){
                echo "<script language=\"JavaScript\">\n";
                echo "alert(\"" . $stringa . "\");\n";
                echo "</script>";
              }

              echo '<center>';
              echo '<p>'.$row['categoria'].'  '.$row['importo'].'€ '.$row['dataInserimento'].'</p>';
              echo '</center>';
            }

            


        ?>
        </div>
      </div>
    </div>
    <!-- Script -->
    <script src="script.js"></script>
  </body>
</html>