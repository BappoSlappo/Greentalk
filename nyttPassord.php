<!-- Gir brukeren mulighet for nytt passord -->
<?php
  include("Include/db_pdo.php");
  include("Header/headerLogReg.php");
  session_start();
  include('Include/sjekkLov1Hovedsider.php');
?>
<!DOCTYPE html>
<html>
  <main>
    <section class="container">
        <section class="wrapper animated bounceInDown">
          <section class="login">
          <?php
            if(isset($_SESSION['passReset'])){
              if($_SESSION['passReset'] == 1){

                echo "<p style='text-align:center'>Passord endret</p>
                <a href='default.php' class='vis-mer' style='text-align:center'>Tilbake</a>";
                $_SESSION['passReset'] = 0;
              }else{
                printSkjema();
              }
            }else{
              printSkjema();
            }

            function printSkjema(){
              echo'
                <h3>Endre passord</h3>
                <form action="Action/nyttPassordAction.php" method="POST">
                  <p>
                    <label>Gammelt passord</label>
                    <input type="password" name="boomerPass" id="bruker" tabindex="4" autofocus>
                  </p>
                  <p>
                    <label>Nytt Passord</label>
                    <input type="password" name="passord" id="passord" tabindex="5">
                  </p>
                  <p>
                    <label>Gjenta Nytt passord</label>
                    <input type="password" name="passord2" id="passord" tabindex="6">
                  </p>
                  <p>
                  <p class="full">
                    <button type="submit" value="sjekk" name="knapp" tabindex="7">Endre passord</button>
                  </p>
                  <p class="full">
                        <a href="default.php" tabindex="8">Tilbake til hjemmesiden</a>
                    </p>
                </form>';
            }

            ?>
                <?php
                if(isset($_SESSION['tilbakemelding'])){
                  if($_SESSION['tilbakemelding'] == 4){
                    echo "<p>Gammelt passord er feil</p>";
                    $_SESSION['tilbakemelding'] = 0;
                  } elseif ($_SESSION['tilbakemelding'] == 6){
                    echo "<p>Nye passord er ikke like</p>";
                    $_SESSION['tilbakemelding'] = 0;
                  }
                }
              ?>
            <div tabindex="9" onfocus="document.getElementById('først').focus()"></div>
          </section>
        </section>
      </section>
    </main>
</body>
</html>
<!-- Skrevet og kontrollert i fellesskap av Gruppe 6 -->