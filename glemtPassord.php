<?php
  include("Header/headerLogReg.php");
?>
<!DOCTYPE html>
<html>
  <!-- Laget av Mikkel -->
  <main>
  <body>
    <section class="container">
        <section class="wrapper animated bounceInDown">
          <section class="login">
            <h3>Glemt Passord</h3>
            <p>Tast inn brukernavn og epost, du vil få nytt passord på mail</p>
            <form action="Action/glemtAction.php" method="POST">
                <p>
                    <label>Brukernavn</label>
                    <input type="text" name="brukernavn" autofocus required>
                </p>

                <p>
                    <label>Epostadresse</label>
                    <input type="email" name="email" required>
                </p>
                <p class="full">
                    <button type="submit" value="sjekk" name="knapp">Send epost</button>
                </p>
                <p class="full">
                    <a href="logginn.php">Tilbake til logg inn</a>
                </p>
            </form>

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