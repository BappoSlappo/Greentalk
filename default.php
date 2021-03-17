<?php
    include("Include/db_pdo.php");
    include("Header/header.php");
?>
<!DOCTYPE html>
<html>
<main>
<!-- Siden er blitt laget og oppdatert av alle gruppemedlemmene-->
    <!-- Her kommer kode for aktuelt -->
    <section id="aktuelt" class="Anker">
        <?php
        if(isset($_SESSION['brukertype'])){
            if($_SESSION['brukertype'] == 1 or $_SESSION['brukertype'] == 2) {
                echo '<a href="lagArtikkel.php" class="button">Last opp artikkel</a>';
            }
        }
        ?>
        <section><h1>Aktuelt</h1>
        <section class="rad" onclick="SWIPE();">
            <?php
                $sql = "SELECT hvor, artnavn, artingress, arttekst, brukernavn, artikkel.idartikkel 
                FROM artikkel, bilder, artikkelbilde, bruker WHERE bilder.idbilder = artikkelbilde.idbilde AND (artikkelbilde.idartikkel = artikkel.idartikkel AND artikkel.bruker = bruker.idbruker AND hvor NOT LIKE'%ArtArr%') ORDER BY artikkel.idartikkel DESC";
                $stmt = $db->prepare($sql);
                $stmt->execute();
                if($stmt->rowCount()){
                    $antall = 0;
                    $klas0 = "skjul0-Ak";
                    $klas3 = "skjul3-Ak";
                    $klas10 = "skjul10-Ak";
                    $klas30 = "skjul30-Ak";
                    $klas100 = "skjul100-Ak";

                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $overskrivt = $row['artnavn'];
                        $art = $row['artingress'];
                        $bilde = $row['hvor'];
                        $tekst = $row['arttekst'];
                        $bruker = $row['brukernavn'];
                        $idartik = $row['idartikkel'];

                        if($antall >=3 and $antall<10) {
                            skrivArt($klas3,$overskrivt,$art,$bilde,$tekst,$bruker,$db,$idartik);
                            $antall++;
                            
                        } else if ($antall >= 10 and $antall< 30){
                            skrivArt($klas10,$overskrivt,$art,$bilde,$tekst, $bruker,$db,$idartik);
                            $antall++;
                        } else if ($antall >= 30 and $antall <100) {
                            skrivArt($klas30,$overskrivt,$art,$bilde, $tekst,$bruker, $db,$idartik);
                            $antall++;
                        } else if ($antall >= 100){
                            skrivArt($klas100,$overskrivt,$art,$bilde,$tekst,$bruker, $db,$idartik);
                            $antall++;
                        } else {
                            skrivArt($klas0,$overskrivt,$art,$bilde,$tekst,$bruker, $db,$idartik);
                            $antall++;
                        }
                    }
                }
                // Her kommer kode for å presentere artikkelen i modalen
                function skrivArt($klasse, $overskrivt, $art, $bilde,$tekst,$bruker, $db,$idartik){
                    echo "
                    <article class='artikkel ".$klasse." modalKnapp'>
                        <img src='".$bilde."' alt='Artikkelbilde' class='artikkelBilde'>
                        <h2>".$overskrivt ."</h2>
                        <p>". $art."</p>
                    </article>
                        <section class='modal modalid'>
                            <section class='modal-innhold'>
                                <section class='modal-header'>
                                    <span class='close'>&times;</span>
                                        <h2>".$overskrivt."</h2>
                                </section>
                                <section class='modal-body' id='interessemodal'>
                                    <section class='navn-container'>
                                    <img src='". $bilde."' alt='Profilbilde' class='artikkelBilde'>
                                    <section>
                                        <p>Tekst: ".$tekst."</p>
                                        <p>Skrevet av: ".$bruker."</p>
                                        </section>
                                        <a href='lagKommentar.php?artikkelid=".$idartik."'class='vis-mer'>Skriv kommentar</a>
                                        <h3>Kommentarer:</h3>
                        ";

                        $sqlKom = "SELECT tekst, kommentar.tid, artikkel, fnavn, enavn FROM kommentar, bruker, artikkel WHERE kommentar.bruker = bruker.idbruker AND kommentar.artikkel=:ar GROUP BY kommentar.tid";
                        $stmtKom = $db->prepare($sqlKom);
                        $stmtKom->bindParam(':ar', $idartik);
                        $stmtKom->execute();
                        if($stmtKom->rowCount()){
                            while($row = $stmtKom->fetch(PDO::FETCH_ASSOC)) {
                                echo "<article class='kommentarKom'>
                                        <h4>".$row['fnavn']." ". $row['enavn']."</h4>
                                        <p>".$row['tekst']."</p>
                                        <p>".$row['tid']."</p>
                                    </article>";
                            }
                        }
                        echo "
                        </section>
                        </section>
                        </section>
                        </section>
                        ";
                }
                ?>
        
        <!-- Rad artikkel slutt -->
        </section>
        </section>
        <button class="vis-mer" tabindex="7" id="vis-mer-Ak" onclick="visMerAk()">Vis mer</button>
        <a href="default.php#aktuelt" style="text-decoration:none;"> 
            <button  class="vis-mer" id="knappForSkjul-Ak" style="display:none" onclick="visMindreAk()">Vis mindre</button> 
        </a> 
       
    </section>
    <!-- Her kommer kode for arrangementer -->
    <section id="arrangementer" class="Anker">
        <?php
            if(isset($_SESSION['brukertype'])){
                if($_SESSION['brukertype'] == 1 or $_SESSION['brukertype'] == 2) {
                    echo '<a href="lagArrangement.php" class="button"> Opprett et arrangement</a>';
                }
            }
        ?>
        <h1>Arrangementer</h1>
        <section class="rad" onclick="SWIPE();">
            <?php
                $sql = "SELECT hvor, brukernavn, eventnavn, eventtekst, tidspunkt, veibeskrivelse, fylke, idevent FROM eventbilde, `event`, bruker,bilder
                WHERE bilder.idbilder = eventbilde.bilde AND (eventbilde.event = event.idevent AND event.idbruker = bruker.idbruker AND hvor NOT LIKE'%ArtArr%') ORDER BY event.idevent DESC";
                $stmt = $db->prepare($sql);
                $stmt->execute();

                
                if($stmt->rowCount()){
                    $antall = 0;
                    $klas0 = "skjul0-Ar";
                    $klas3 = "skjul3-Ar";
                    $klas10 = "skjul10-Ar";
                    $klas30 = "skjul30-Ar";
                    $klas100 = "skjul100-Ar";

                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $overskrivt = $row['eventnavn'];
                        $hvor = $row['hvor'];
                        $art = $row['eventtekst'];
                        $tidpunkt = $row['tidspunkt'];
                        $fylke = $row['fylke'];
                        $idevent = $row['idevent'];
                        $adresse= $row['veibeskrivelse'];
                        $brukernavn = $row['brukernavn'];

                        $svart = 0;
                        // Sjekker om bruker har svart på arrangementet
                        $sqlSjekk = "SELECT interessert FROM påmelding WHERE bruker_id=:br AND event_id=:ev";
                        $stmtSjekk = $db->prepare($sqlSjekk);
                        $stmtSjekk->bindParam(':br', $_SESSION['idbruker']);
                        $stmtSjekk->bindParam(':ev', $idevent);
                        $stmtSjekk->execute();
                        if($stmtSjekk->rowCount()) {
                            
                            // Hvis bruker har svart før
                            while($rad = $stmtSjekk->fetch(PDO::FETCH_ASSOC)){
                                $tallKom = $rad['interessert'];
                                if($tallKom == 'Kan ikke'){
                                    $svart = 2;
                                } else if($tallKom == 'Interessert'){
                                    $svart = 1;
                                }
                            }
                        }
                        
                        if($antall >=3 and $antall<10) {
                            skrivAr($klas3,$overskrivt,$art,$tidpunkt,$adresse,$fylke,$brukernavn,$idevent,$svart,$db,$hvor);
                            $antall++;
                            
                        } else if ($antall >= 10 and $antall< 30){
                            skrivAr($klas10,$overskrivt,$art,$tidpunkt,$adresse,$fylke,$brukernavn,$idevent,$svart,$db,$hvor);
                            $antall++;
                        } else if ($antall >= 30 and $antall <100) {
                            skrivAr($klas30,$overskrivt,$art,$tidpunkt,$adresse,$fylke,$brukernavn,$idevent,$svart,$db,$hvor);
                            $antall++;
                        } else if ($antall >= 100){
                            skrivAr($klas100,$overskrivt,$art,$tidpunkt,$adresse,$fylke,$brukernavn,$idevent,$svart,$db,$hvor);
                            $antall++;
                        } else {
                            skrivAr($klas0,$overskrivt,$art,$tidpunkt,$adresse,$fylke,$brukernavn,$idevent,$svart,$db,$hvor);
                            $antall++;
                        }
                    }
            }
            function skrivAr($klasse, $overskrivt,$art,$tidpunkt,$adresse,$fylke,$brukernavn,$idevent,$svart,$db,$hvor){
                echo"<article class='artikkel ".$klasse." modalKnapp'>
                        <img src='".$hvor."' 
                            alt='Artikkelbilde' class='artikkelBilde' '>
                    <h2>".$overskrivt ."</h2>
                    <p>". $art."</p>
                    </article>";
                    
                //Her kommer kode for å vise arrangementet i modal
                echo   "<section class='modal modalid'>
                            <section class='modal-innhold'>
                                <section class='modal-header'>
                                    <span class='close'>&times;</span>
                                    <h2>".$overskrivt."</h2>
                                </section>
                                <section class='modal-body'>
                                    <section id='om' class='navn-container'>
                                    
                                        <img src='".$hvor."' class='arrangBilde'>
                                        <p class='sted'><strong>Tidspunkt:</strong> ".$tidpunkt." <span style='display: block'><strong>Adresse:</strong> ".$adresse." </span></p>
                                        <p class='beskrivelse'><strong>Beskrivelse:</strong> ".$art."</p>
                                        <p class='opprettet'>Opprettet av <a href='interesser.php?brukernavn=".$brukernavn."'>".$brukernavn."</a></p>";
                                if(isset($_SESSION['idbruker'])){

                                echo "    
                                <form action='Action/oppdaterArr.php' method='POST'>
                                    <select class='status' name='arrValg' id='valgar')>
                                        <option value='0'";if($svart==0){echo "selected='selected'";}echo">Skal</option>
                                        <option value='1'";if($svart==1){echo "selected='selected'";}echo">Interessert</option>
                                        <option value='2'";if($svart==2){echo "selected='selected'";}echo">Kan ikke</option>
                                    </select>
                                    <input value='".$idevent."' name='knappen' style='display:none;'>
                                    <input type='submit' value='Send' class='vis-mer'>;
                                </form>";
                                }
                                echo "
                                </section>
                                </section>";
                                // SQL onclick='tester(".$idevent.")'
                                $sqlFinn = "SELECT fnavn, enavn, interessert FROM påmelding,bruker WHERE event_id=:ev AND påmelding.bruker_id = bruker.idbruker GROUP BY fnavn, enavn";
                                $stmtFinn = $db->prepare($sqlFinn);
                                $stmtFinn->bindParam(':ev', $idevent);
                                $stmtFinn->execute();

                                $liste = array();

                                if($stmtFinn->rowCount()) {
                                    while($radF=$stmtFinn->fetch(PDO::FETCH_ASSOC)){
                                        $type= $radF['interessert'];
                                        $navn = $radF['fnavn']. " ". $radF['enavn'];
                                        $liste[]=$type;
                                        $liste[]=$navn;
                                    }
                                }
                                // Printer ut for hver img src='Bilder/ikoner/c.svg'
                                // Skal
                        echo     '<section class="grid-3-container">';
                                $skal = '"skalVis"';
                                $kani = '"kaniVis"';
                                $inte = '"intVis"';
                        echo    "<section class='arrangDropup'>
                                <button class='brukerKnapp' onclick='arrangJS(".$skal.")' id='skal'>Skal </button>";
                        echo    "<section class='contFolk'>";
                                for($i =0; $i<count($liste)-1;$i+=2){
                                    if($liste[$i]=='Skal'){
                        echo        "<section id='arrangId' class='arrang-content skalVis'>
                                        <p>".$liste[$i+1]."</p>
                                    </section>";
                                    }
                                }
                        echo   "
                                </section>
                                </section>
                                <section class='arrangDropup'>
                                <button class='brukerKnapp' onclick='arrangJS(".$kani.")' id='kanIkke'>Kan ikke </i></button>";
                        echo    "<section class='contFolk'>";
                                for($i=0; $i<count($liste)-1;$i+=2){
                                    if($liste[$i]=='Kan ikke'){
                        echo        "<section id='arrangId' class='arrang-content kaniVis'>
                                        <p>".$liste[$i+1]."</p>
                                    </section>";
                                    }
                                }
                        echo   "</section>
                                </section>
                                <section class='arrangDropup'>
                                <button class='brukerKnapp' onclick='arrangJS(".$inte.")' id='interessert'>Interessert </button>";
                        echo    "<section class='contFolk'>";    
                                for($i=0; $i<count($liste)-1;$i+=2){
                                    if($liste[$i]=='Interessert'){
                        echo        "<section id='arrangId' class='arrang-content intVis'>
                                        <p>".$liste[$i+1]."</p>
                                     </section>";
                                    }
                                }
                        echo    "</section>
                                </section>
                            </section>

                                            
                            </section>
                        </section>
                        ";


            }
            ?>
        <!-- Visning av arrangementer er ferdig -->
        </section>

        <button class="vis-mer" tabindex="8" id="vis-mer-Ar" onclick="visMerAr()">Vis mer</button>
        <a href="default.php#arrangementer" style="text-decoration: none;">  
            <button class="vis-mer" id="knappForSkjul-Ar" style="display:none" onclick="visMindreAr()">Vis mindre</button> 
        </a>
    </section>
    <!-- Kort om oss -->
    <section id="omoss">
        <h2>Om oss</h2>
        <p>Nettstedet Greentalk er et sted hvor alle
            kan bidra til å belyse og komme med nødvendige tiltak for å fikse de klimaproblemene
        verden står overfor.
        </p>
        <p>Her kan du se artikler og fremtidige arrangementer. Du kan også logge inn for å laste opp egne artikler 
            eller opprette egne arrangementer. 
        </p>
    </section>

</main>    
<!-- Knapp som tar brukeren til toppen -->
<button id="topBtn" tabIndex=10 onfocus="document.getElementById('først').focus(); backToTop();"><i class="pil opp"></i></button>
<footer id="footer" class="rad" tabindex="9">
    <h4>Kontakt oss:</h4>
    <p>E-post:<br>
    greentalk@green.talk</p>
    <p>Postadresse:<br>
    <a href="https://goo.gl/maps/NY7Dyr11Qd9khBMW8">Adressen 1 grønnstedet, 
        1234 Grønnland</a></p>
</footer>
</body>
<?php
include('Include/footer.php');
?>
</html>
<!-- Skrevet og kontrollert i fellesskap av Gruppe 6 -->