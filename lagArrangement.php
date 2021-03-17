<!-- Laget av Erlend og Mikkel, sjekket i fellesskap -->
<?php
    include("Include/db_pdo.php");
    include("Header/header.php");
    include('Include/sjekkLov2Hovedsider.php');
?>
<!DOCTYPE html>
<html>
<main class="lagArrangement">
    <h1><u>Opprett Arrangement</u></h1>
    <section class="container">  
        <form class="Lag_Arr_Art" action="Action/lagArrangementAction.php" method="POST" enctype="multipart/form-data">
            <fieldset>
                <input placeholder="Arrangement navn" maxlength="45" name="overskrift" type="text" tabindex="1" required autofocus>
            </fieldset>
            <fieldset>
                <textarea placeholder="Arrangement beskrivelse" maxlength="1000" name="artigress" type="textarea-field" tabindex="2" required autofocus></textarea>
            </fieldset>
            <fieldset>
                <textarea placeholder="Veibeskrivelse" maxlength="250" name="veiBes" type="textarea-field" tabindex="3" required autofocus></textarea>
            </fieldset>
            <fieldset>
                <img class="SentrertBilde" id="bildePrew" style="border:none;">
                <input placeholder="bilde" type="file" name="bildeInn" value="Velg fil" tabindex="4" onchange="visFil(event)" required autofocus>
            </fieldset>
            
            <fieldset>
            <p>Fylke</p>   
                <select name="fylke" tabindex="5">
                    <option value="1">Oslo</option>
                    <option value="2">Rogaland</option>
                    <option value="3">Møre og Romsdal</option>
                    <option value="4">Nordland</option>
                    <option value="5">Troms og Finnmark</option>
                    <option value="6">Innlandet</option>
                    <option value="7">Vestfold og Telemark</option>
                    <option value="8">Agder</option>
                    <option value="9">Vestland</option>
                    <option value="10">Trøndelag</option>
                    <option value="11">Viken</option>
                </select>
            </fieldset>
            <fieldset>
            <p>Tid og dato</p>
                <input tabindex="6" type="datetime-local" name="tidinn" required autofocus>
            </fieldset>
            <fieldset>
                <button tabindex="7" type="submit" value="Last opp">Last opp</button>
            </fieldset>
        </form>
    </section>
</main>

<?php
    include("Include/footer.php");
?>
</html>