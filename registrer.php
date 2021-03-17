<!-- Registrering av en ny bruker -->
<?php
  include("Header/headerLogReg.php");
?>
<!DOCTYPE html>
<html>
<body>
    <main>
    <section class="container">
        <section class="wrapper animated bounceInDown">
          <section class="login">
            <h3>Registrer en bruker</h3>
            <form action="Action/regAction.php" method="POST">
                <p>
                    <label>Brukernavn</label>
                    <input type="text" name="brukernavn" autofocus required>
                </p>

                <p>
                    <label>Epostadresse</label>
                    <input type="email" name="email" required>
                </p>
                <p>
                    <label>Passord</label>
                    <input type="password" name="passord" required>
                </p>
                <p>
                    <label>Passord igjen</label>
                    <input type="password" name="passord2">
                </p>
                <p>
                    <label>Fornavn</label>
                    <input type="text" name="fnavn" required>
                </p>
                <p>
                    <label>Etternavn</label>
                    <input type="text" name="enavn" required>
                </p>
                <p>
                    <label>Telefonnummer</label>
                    <input type="text" name="tlf">
                </p>
                <p>
                <p class="full" id="lit_reg">
                    <button type="submit" value="sjekk" name="knapp">Registrer</button>
                </p>
                <p class="full" id="lit_til">
                    <a href="logginn.php">Tilbake til logg inn</a>
                </p>
            </form>
            <?php
                if(isset($_SESSION['tilbakemelding'])){

                    if($_SESSION['tilbakemelding'] == 4){
                        echo "<p>Passordene er ikke like</p>";
                        $_SESSION['tilbakemelding'] = 0;
                    } elseif($_SESSION['tilbakemelding'] = 5) {
                        echo "<p>Brukernavn/epost er allerede i bruk</p>";
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