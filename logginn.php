<?php
  include("Include/db_pdo.php");
  session_start();
  include("Header/headerLogReg.php");
  
?>
<!DOCTYPE html>
<html>
  <body>
  <main>
    <section class="container">
        <section class="wrapper animated bounceInDown">
          <section class="login">
            <h3>Logg inn</h3>
            <form action="Action/logAction.php" method="POST">
              <p>
                <label>Brukernavn</label>
                <input type="text" name="bruker" id="bruker" required autofocus>
              </p>
              <p>
                <label>Passord</label>
                <input type="password" name="passord" required id="passord">
              </p>
              <p>
              <p class="full">
                <button type="submit" value="sjekk" name="knapp">Logg inn </button>
              </p>
            <p class="full">
                <a href="registrer.php">Lag bruker</a>
              </p>
            <p class="full"> 
              <a href="glemtPassord.php">Glemt passord</a>
              </p> 
            </form>
                <?php
                if(isset($_SESSION['tilbakemelding'])){
                  if($_SESSION['tilbakemelding'] == 1){
                    echo "<p>Forsøk igjen om 5 minutt</p>";
                    $_SESSION['tilbakemelding'] = 0;
                  } elseif ($_SESSION['tilbakemelding'] == 2){
                    echo "<p>Feil brukernavn/passord</p>";
                    $_SESSION['tilbakemelding'] = 0; 
                  }elseif ($_SESSION['tilbakemelding'] == 5){
                    echo "Brukeren er avregistrert";
                    $_SESSION['tilbakemelding'] = 0;
                  } 
                }
              ?>
          </section>
        </section>
      </section>
  </main>
  <footer>
  <script src="JavaScript filer/scroll.js"></script>
  </footer>
</body>
</html>
<!-- Skrevet og kontrollert i fellesskap av Gruppe 6 -->