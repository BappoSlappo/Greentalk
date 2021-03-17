<!-- Laget av Erlend og Mikkel -->
<?php
    include("Include/db_pdo.php");
    include("Header/header.php");
    include('Include/sjekkLov1Hovedsider.php');
    $artikkelid = $_GET['artikkelid'];

?>
<!DOCTYPE html>
<html>
<main>
    <h1 style="text-align:center"><u>Lag en kommentar</u></h1>
    <section class="lagArtikkel">
            <form action="Action/lagKommentarAction.php" method="POST">
                <label>Kommentar innhold:</label>
                <textarea placeholder="Kommentar tekst" name="tekst"></textarea>
                <input type="text" name="artID" style="display:none;" value=<?php echo '"'.$artikkelid . '"'?>>
        </section>            
    </section>
    <input type="submit" class="vis-mer" style="position:static;" name="submit" value="Last opp">
    </form>
    
</main>
<?php
    include("Include/footer.php");
?>
</html>