<!-- Laget av Erlend og Mikkel, sjekket i fellesskap -->
<?php
    include("Include/db_pdo.php");
    include("Header/header.php");
    include('Include/sjekkLov2Hovedsider.php');
?>
<!DOCTYPE html>
<html>
<main class="lagArtikkel">
    <h1><u>Lag en artikkel</u></h1>
    <section class="container">  
        <form class="Lag_Arr_Art" action="Action/lagArtikkelAction.php" method="POST" enctype="multipart/form-data">
            <fieldset>
                <input placeholder="Overskrift" maxlength="45" name="overskrift" type="text" tabindex="1" required autofocus>
            </fieldset>
            <fieldset>
                <textarea placeholder="Artikkelingress" maxlength="255" name="artigress" type="textarea-field" tabindex="2" required autofocus></textarea>
            </fieldset>
            <fieldset>
                <img class="SentrertBilde" id="bildePrew" style="border:none;">
                <input placeholder="bilde" type="file" value="Velg fil" name='bildeInn' tabindex="3" onchange="visFil(event)" required autofocus>
            </fieldset>
            <fieldset>
                <textarea placeholder="Artikkeltekst" maxlength="1000" name="tekst" class="textarea-field" tabindex="4" required autofocus></textarea>
            </fieldset>
            <fieldset>
                <button name="submit" type="submit" id="contact-submit" tabindex="5" value="Last opp">Last opp</button>
            </fieldset>
        </form>
    </section>
</main>

<?php
    include("Include/footer.php");
?>
</html>