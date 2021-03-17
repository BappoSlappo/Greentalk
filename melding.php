<!-- Laget av Sigve og Erlend, testet i felleskap -->
<?php
    include("Include/db_pdo.php");
    include('Header/header.php');
    include('Include/sjekkLov1Hovedsider.php');
?>
<!DOCTYPE html>
<html>
<body>
<main>
    <section class="melding" onclick="SWIPE();">
        <section class="meldingknapper" id="meldingknapp">
            <article class="button typeBoksValgt" onclick="endreBoks(0)">
                <p>Innboks</p>
            </article>

            <article class="button" onclick="endreBoks(1)">
                <p>Sendte</p>
            </article>

            <article class="button" onclick="endreBoks(2)">
                <p>Papirkurv</p>
            </article>

            <article class="button" onclick="endreBoks(3)">
                <p>Advarsler</p>
            </article>
            <button class=" modalKnapp button" id="SkrivMldKnapp">Skriv melding</button>
        </section>
        
        <!-- lag melding modal -->
		<section id="modalid" class="modal modalid" >
			<section class="modal-innhold">
				<section class="modal-header">
					<span class="close">&times;</span>
					<h2>Skriv melding</h2>
				</section>
				<section class="modal-body">
                <form>
                    <label for="tittelMel">Overskrift:</label>
                    <input type="text" id="tittelMel" name="tittel" autofocus required></br></br>

                    <label for="mottakerMel">Mottaker:</label>
                    <input value="<?php if(isset($_GET['mottaker'])){echo $_GET['mottaker'];}?>" placeholder="Tidligere mottakere"type="text" id="mottakerMel" name="mottaker" onkeyup="finnBrukerMelding(this.value)" required></br></br>
                    <section id="mottakereL">
                    </section>
                    
                    <label for="utTall">Melding:</label><br><br>
                    <textarea id="utTall" rows="8" cols="40" name="tekst" maxlength="1024" oninput="endreAntall()"></textarea></br>
                    <p id="antallTegn">0/1024</p>
                    <section id="utTest"></section>
                    <input type="button" onclick="sendMelding()" name="submit" class="vis-mer" value="Send Melding">
                </form>

				</section>
			</section>
		</section>

        <section id="data">
            <section id='meldingVis'>
            </section>
            <section id='fremVis'>
            <?php
                // Fire klasser
                // innboks (Alt)
                // Ulest
                // Papirkurv (boss)
                // advarsler

                $sql = "SELECT idmelding, tittel, tekst, brukernavn, lest, papirkurv, tid 
                        FROM melding, bruker 
                        WHERE (mottaker = :br) AND (bruker.idbruker = melding.sender) 
                        ORDER BY lest DESC";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':br', $_SESSION['idbruker']);
                $stmt->execute();
                if($stmt->rowCount()) {
                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $ferdig = '"'.$row['idmelding'].'"';
                        echo "
                        <article class='meldingPre ";
                        if($row['papirkurv'] == 1){
                            echo"papirK";
                        } else if($row['lest'] == 0){
                            echo"ulestK";
                        }
                        echo"'>
                            
                            <input class='reeeee' style='display:none' value=".$ferdig.">
                            <span class='boss' value=".$ferdig." onclick='boss()'";
                            if($row['papirkurv']==0){
                                echo "style='color:red;'>X";
                            } else{
                                echo "style='color:green;'>-";
                            }
                            echo"</span>
                            <h4>".$row['tittel']."</h4>
                            <p>".$row['tekst']."</p>
                            <p>Avsender: <a href='interesser.php?brukernavn=".$row['brukernavn']."'>".$row['brukernavn']."</a></p>
                            <p>Sendt: ".$row['tid']."</p>
                        </article>
                        ";
                        
                    }
                    
                }

                $sqlSendte = "SELECT idmelding, tittel, tekst, brukernavn, lest, papirkurv, tid FROM melding, bruker WHERE (sender = :br) AND (bruker.idbruker = melding.mottaker) ORDER BY tid DESC";
                $stmtSendte = $db->prepare($sqlSendte);
                $stmtSendte->bindParam(':br', $_SESSION['idbruker']);
                $stmtSendte->execute();

                if($stmtSendte->rowCount()) {
                    while($row = $stmtSendte->fetch(PDO::FETCH_ASSOC)) {
                        
                        $ferdig = '"'.$row['idmelding'].'"';
                        echo "
                        <article class='meldingPre sendtK";
                        echo"'>
                            <input class='reeeee' style='display:none' value=".$ferdig.">
                            <h4>".$row['tittel']."</h4>
                            <p>".$row['tekst']."</p>
                            <p>Mottaker: ".$row['brukernavn']."</p>
                            <p>Sendt: ".$row['tid']."</p>
                        </article>
                        ";
                    }
                }

                // advarsler

                $sqlAdvarsel = "SELECT idadvarsel, advarseltekst FROM advarsel WHERE bruker=:br ORDER BY idadvarsel DESC";
                $stmtAdvarsel = $db->prepare($sqlAdvarsel);
                $stmtAdvarsel->bindParam(":br", $_SESSION['idbruker']);
                $stmtAdvarsel->execute();

                if($stmtAdvarsel->rowCount()){
                    while($row=$stmtAdvarsel->fetch(PDO::FETCH_ASSOC)){
                        echo "
                        <article class='meldingPre advarsler' style='display:none'>
                        <h4>Advarsel fra administrator</h4>
                        <p>".$row['advarseltekst']."</p>
                        </article>
                        ";
                    }
                }
                ?>
            </section>
            </section>
        </section>
    </section>
</main>

<footer>
<button id="topBtn"><i class="fas fa-arrow-up"></i></button>
<?php
include('Include/footer.php');
?>
</footer>
</body>
</html>
