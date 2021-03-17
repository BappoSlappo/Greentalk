<?php
    include("../Include/db_pdo.php");
    session_start();
    include('../Include/sjekkLov1.php');
    // Sjekk om bruker har bruk for å være inne på siden (Siden er bare en action side og skal ikke kunne nås av bruker normalt sett)
    if(isset($_GET['verdi'])){

        $verdi = $_GET['verdi'];

        $sql = "SELECT idmelding, tittel, tekst, brukernavn, lest, papirkurv FROM melding, bruker WHERE mottaker = :br AND bruker.idbruker = melding.sender";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':br', $_SESSION['idbruker']);
        $stmt->execute();
        
        if($stmt->rowCount()){
            
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
                if($verdi == 0){
                if($row['papirkurv']== 0){
                        lagMeld($row['tittel'],$row['brukernavn'], $row['tekst'],$row['lest'], $row['idmelding']);
                }
                } else if($verdi == 1){
                    if($row['lest']==0){
                        lagMeld($row['tittel'],$row['brukernavn'], $row['tekst'],$row['lest'], $row['idmelding']);
                    }

                }else {
                    if($row['papirkurv'] ==1) {
                        lagMeld($row['tittel'],$row['brukernavn'], $row['tekst'],$row['lest'], $row['idmelding']);
                    }
                }

            }
        }

        function lagMeld($tittel, $brukernavn, $tekst,$lest,$idmelding){
            echo "                        
            <a onclick='lestMel(".$lest.",".$idmelding.")' onload='oppdaterKlasse()'>
            <button class='button modalKnapp' style='display: block; float: none; margin: auto; width: 300px; margin-top: 10px; position:static;'>".$tittel ."</button>
            </a>
            <section class='modal modalid'>
                <section class='modal-innhold'>
                    <section id='utMeld'>
                        <section class='modal-header'>
                            <span class='close'>&times;</span>
                            <h2>".$tittel."</h2>
                        </section>
                        <section class='modal-body' id='interessemodal'>
                            <section>
                                <p>Avsender: ".$brukernavn."</p>
                                <p>".$tekst."</p>
                            </section>
                            <section>
                                <button class='vis-mer'>Slett Meldingen</button>
                            </section>
                        </section>
                    </section>
                </section>
            </section>";
        }
    } else {
        header("Location: ../default.php");
    }

?>