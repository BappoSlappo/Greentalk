<?php
    include("Include/db_pdo.php");
    include("Header/header.php");
    include("Include/sjekkLovAdminHovedsider.php");
?>
<!DOCTYPE html>
<html>
<!--Laget av Stian, sjekket i fellesskap
Dette er siden som presenteres for brukere som er administratorer og inneholder funksjoner
en administrator skal ha-->
<section class="admin">
    <h3>Gi advarsel</h3>
    <p>Finn brukere med rapporterte misbruk</p>
    <input type="text" id="advarselbruker" tabindex="8" onkeyup="finnBruker(this.value)" name="advarselbruker" placeholder="Søk etter brukere">
	<div id="utbrukerA"></div>
    <form action="Action/giAdvarselAction.php" method="POST">
        <input type="text" name="brukerValgte" tabindex="9" readonly id="brukerValgt" placeholder="Valgt bruker" required>
        <section>
            <h4>Tidligere rapporteringer</h4>
            <h5 id='statusUt'>Status:</h5>
            <article id="utTidligereAdvarsler">
            </article>
            <article id="utEkskluder"></article>
        </section>
        <textarea id="advarselTekst" name="advarselTekst" tabindex="10" placeholder='Skriv advarsel tekst' required></textarea>
        
        <input type="submit" class="vis-mer">
        
    </form>
</section>

<section class="admin">
    <h3>Gi rettigheter</h3>
    <input type="text" id="rettigBruker" tabindex="11" onkeyup="finnBrukerRettig(this.value)" name="rettigBruker" placeholder="Søk etter brukere">
	<div id="utbrukerR"></div>
    <form action="Action/giRettighetAction.php" method="POST">
        <input type="text" name="brukernavn" id="rettighetMottak" readonly>
        <select id='tittel' name="tittel">
            <option value="2">Redaktør</option>
            <option value="1">Administrator</option>
        </select>
        <input type="submit" class="vis-mer">
    </form>
</section>

<section class="admin">
    <h3>Opprett regel</h3>
    <form action="Action/lagRegelAction.php" method="POST" style="text-align:center">
        <label for="tekstRegel" >Opprett en regel</label>
        <textarea id='tekstRegel' name="tekstRegel" tabindex="12" placeholder='Skriv inn regel'></textarea>
        <input type="submit" class="vis-mer">
    </form>
</section>

<section class="admin">
    <h3>Lag rapport</h3>
    <a href="brukerRapport.php" tabindex="13" ><button class="vis-mer" >Rapporten</button></a>
</section>
<button id="topBtn" tabIndex=14 onfocus="document.getElementById('først').focus(); backToTop();"><i class="pil opp"></i></button>

<?php
    include("Include/footer.php");
?>
</html>
