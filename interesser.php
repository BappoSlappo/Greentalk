<!-- Laget av Sigve, Hannah og Sanan -->
<?php
    include("Include/db_pdo.php");
    include('Header/header.php');
    include('Include/sjekkLov1Hovedsider.php');
?>
<!DOCTYPE html>
<html>
<section class="rad" id="int-2-col" onclick="SWIPE();">
    <section tabindex="8" class="">
    <h2 style="text-align: center;"> Interesser</h2>
    <p style="text-align: center;">Brukere med interesse om 
        <?php 
        if(isset($_POST['sok'])) {
            $_SESSION['sok'] = $_POST['sok'];
        }
        if(isset($_SESSION['sokInt'])) {
                echo $_SESSION['sokInt'];
            }   

        ?>:</p>
        <?php
        // Printe ut alle brukere med samme interesse som deg
            $sql = "SELECT brukernavn, fnavn, enavn, epost, telefonnummer, beskrivelse, idbruker, visfnavn, visenavn, visepost, vistelefonnummer, visinteresser, visbeskrivelse FROM bruker, brukerinteresse, interesse, preferanse WHERE (interesse.interessenavn = :inte AND brukerinteresse.bruker != :br) AND (brukerinteresse.interesse = interesse.idinteresse AND bruker.idbruker = brukerinteresse.bruker) AND (bruker.idbruker = preferanse.bruker) GROUP BY brukernavn, idbruker";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':inte', $_SESSION['sokInt']);
            $stmt->bindParam(':br', $_SESSION['idbruker']);
            $stmt->execute();

            if($stmt->rowCount()) {
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $finnesFnavn = $row['visfnavn'];
                    $finnesEnavn = $row['visenavn'];
                    $finnesEpost = $row['visepost'];
                    $finnesTlf = $row['vistelefonnummer'];
                    $finnesInteresser = $row['visinteresser'];
                    $finnesBeskrivelse = $row['visbeskrivelse'];

                    if($finnesFnavn == 1) {
                        $fnavn = $row['fnavn'];
                    } else {
                        $fnavn = 'SKJULT';
                    }
                    if($finnesEnavn == 1) {
                        $enavn = $row['enavn'];
                    } else {
                        $enavn = 'SKJULT';
                    }
                    if($finnesEpost == 1) {
                        $epost = $row['epost'];
                    } else {
                        $epost = 'SKJULT';
                    }
                    if($finnesTlf == 1) {
                        $tlf = $row['telefonnummer'];
                    } else {
                        $tlf = 'SKJULT';
                    } 

                    if($finnesBeskrivelse == 1) {
                        $beskrivelse = $row['beskrivelse'];
                    } else {
                        $beskrivelse = 'SKJULT';
                    }
                    //Modal som vises hvis brukeren trykker på en annen bruker
                    echo "
                    <button class='button modalKnapp' style='display: block; float: none; margin: auto; width: 100%; max-width: 150px; margin-top: 10px; position:static;'>".$row['brukernavn'] ."</button>
                    <section class='modal modalid'>
                        <section class='modal-innhold'>
                            <section class='modal-header'>
                                <span class='close'>&times;</span>
                                <h2>".$row['brukernavn']."</h2>
                            </section>
                            <section class='modal-body' id='navn-container'>
                            <img src='Bilder/profil.png' alt='Profilbilde' class='SentrertBilde' style=grid-row:1; grid-column:1;>
                            
                                <section class='infoModal'>
                                    <p><strong>Fornavn: </strong> ".$fnavn."</p>
                                    <p><strong>Etternavn: </strong> ".$enavn."</p>
                                    <p><strong>Epost: </strong> ".$epost."</p>
                                    <p><strong>Telefon: </strong> ".$tlf."</p>
                                </section>
                                <a href='melding.php?mottaker=".$row['brukernavn']."' class='vis-mer' style='grid-row:2; grid-column:1; margin-bottom:10px;'>Send melding</a>
                                <textarea class='textareaInteres' readonly rows='6' cols='40' placeholder='Ingen beskrivelse tilgjengelig...'>".$beskrivelse."</textarea>
                        </section>
                        <form action='slettInt.php' method='POST'>
                        ";
                        if($finnesInteresser == 1) {
                        $sqlInt ="SELECT interessenavn FROM brukerinteresse, bruker, interesse WHERE brukerinteresse.bruker = :br AND brukerinteresse.interesse = interesse.idinteresse GROUP BY interessenavn LIMIT 20";
			            $stmtInt = $db->prepare($sqlInt);
			            $stmtInt->bindParam(':br', $row['idbruker']);
			            $stmtInt->execute();
                    
                        if($stmtInt->rowCount()){
                            while($rowInt = $stmtInt->fetch(PDO::FETCH_ASSOC)){
                                $in =$rowInt['interessenavn'];
                               echo "<button class='intersbtn' name='visAndre' value='".$in."'>".$in."</button>";
                            }
                        } else {
                            echo "Feil";
                        }
                    } 

                    echo "
                    </form>
                    </section>
                        </section>
                        ";
                        }
                    }
            ?>
        </section>
        <!-- Her vises det brukeren som er søkt på i søkefeltet -->
        <section tabindex="9" class="">
        <h2 style="text-align: center;">Brukere</h2>
        <p style="text-align: center;">Brukere med navn
        <?php 
        if(isset($_POST['sok'])) {
            $_SESSION['sok'] = $_POST['sok'];
        }
        if(isset($_SESSION['sokInt'])) {
                echo $_SESSION['sokInt'];
            }   

        ?>:</p>
        <?php
            // Hvis bruker er valgt
            if(isset($_GET['brukernavn'])){
                $brukerSok = $_GET['brukernavn'];
                $sqlBruker = "SELECT fnavn,enavn, brukernavn,epost,telefonnummer, beskrivelse FROM bruker WHERE brukernavn=:bn";
                $stmtBruker = $db->prepare($sqlBruker);
                $stmtBruker->bindParam(':bn', $brukerSok);
                $stmtBruker->execute();
                if($stmtBruker->rowCount()) {
                    while($row = $stmtBruker->fetch(PDO::FETCH_ASSOC)) {
                       
                        echo "
                        <button class='button modalKnapp' style='display: block; float: none; margin: auto; max-width: 150px; margin-top: 10px; position:static;'>".$row['brukernavn'] ."</button>
                        <section class='modal modalid'>
                            <section class='modal-innhold'>
                                <section class='modal-header'>
                                    <span class='close'>&times;</span>
                                    <h2 id='funnetB'>".$row['brukernavn']."</h2>
                                </section>
                                <section class='modal-body' id='navn-container'>
                                    <img src='Bilder/profil.png' alt='Profilbilde' class='SentrertBilde' style=grid-row:1; grid-column:1;>
                                    <button value='".$row['brukernavn']."' class='vis-mer modalKnapp' style='background-color:red'>Rapporter</button>
                                    <section class='infoModal'>
                                        <p><strong>Fornavn: </strong> ".$row['fnavn']."</p>
                                        <p><strong>Etternavn: </strong> ".$row['enavn']."</p>
                                        <p><strong>Epost: </strong> ".$row['epost']."</p>
                                        <p><strong>Telefon: </strong> ".$row['telefonnummer']."</p>
                                    </section>
                                    <button class='vis-mer' style='grid-row:2; grid-column:1; margin-bottom:10px;'>Send melding</button>
                                    <textarea class='textareaInteres' readonly rows='6' cols='40' placeholder='Ingen beskrivelse tilgjengelig...'>".$row['beskrivelse']."</textarea>
                                </section>
                            </section>
                        </section>
                            ";


                    }
            }
        }else if(isset($_SESSION['sokInt'])) {
            $brukerSok = $_SESSION['sokInt'];
            $sqlBruker = "SELECT fnavn,enavn, brukernavn,epost,telefonnummer, beskrivelse FROM bruker WHERE brukernavn=:bn";
            $stmtBruker = $db->prepare($sqlBruker);
            $stmtBruker->bindParam(':bn', $brukerSok);
            $stmtBruker->execute();
            if($stmtBruker->rowCount()) {
                while($row = $stmtBruker->fetch(PDO::FETCH_ASSOC)) {
                   
                    echo "
                    <button class='button modalKnapp' style='display: block; float: none; margin: auto; max-width: 150px; margin-top: 10px; position:static;'>".$row['brukernavn'] ."</button>
                    <section class='modal modalid'>
                        <section class='modal-innhold'>
                            <section class='modal-header'>
                                <span class='close'>&times;</span>
                                <h2 id='funnetB'>".$row['brukernavn']."</h2>
                            </section>
                            <section class='modal-body' id='navn-container'>
                                <img src='Bilder/profil.png' alt='Profilbilde' class='SentrertBilde' style=grid-row:1; grid-column:1;>
                                <button value='".$row['brukernavn']."' class='vis-mer modalKnapp' style='background-color:red'>Rapporter</button>
                                <section class='infoModal'>
                                    <p><strong>Fornavn: </strong> ".$row['fnavn']."</p>
                                    <p><strong>Etternavn: </strong> ".$row['enavn']."</p>
                                    <p><strong>Epost: </strong> ".$row['epost']."</p>
                                    <p><strong>Telefon: </strong> ".$row['telefonnummer']."</p>
                                </section>
                                <button class='vis-mer' style='grid-row:2; grid-column:1; margin-bottom:10px;'>Send melding</button>
                                <textarea class='textareaInteres' readonly rows='6' cols='40' placeholder='Ingen beskrivelse tilgjengelig...'>".$row['beskrivelse']."</textarea>
                            </section>
                        </section>
                    </section>
                        ";


                }
        }
        }

        ?>
        </section>

        <?php
        // Rapporerings modal
        echo "
        <section class='modal modalid'>
                            <section class='modal-innhold'>
                                <section class='modal-header'>
                                    <span class='close'>&times;</span>
                                    <h2>Rapporter</h2>
                                </section>
                                <section class='modal-body' id='navn-container'>
                                    <h3>Beskrivelse</h3>
                                    <textarea id='beskrivelseRap'></textarea>
                            </section>
                            <p id='utRap' style='text-align:center'></p>
                            <button class='vis-mer' onclick='rapportBruker()'>Rapporter</button>
                        </section>
                        </section>";
                ?>

    </section>
</main>
<button id="topBtn" tabIndex=10 onfocus="document.getElementById('først').focus(); backToTop();"><i class="pil opp"></i></button>


<?php
include('Include/footer.php');
unset ($_SESSION["sokInt"]);
?>
</html>
