<?php
    session_start();
    include("../Include/db_pdo.php");
    include('../Include/sjekkLov1.php');
    // Sjekk om bruker har bruk for å være inne på siden (Siden er bare en action side og skal ikke kunne nås av bruker normalt sett)
    if(isset($_GET['beskrivelse'])){

        $beskirvelse = $_GET['beskrivelse'];
        $brukerRapportert = $_GET['brukerRapportert'];


        $rap ="";

        // Finne id
        $sqlBruker = "SELECT idbruker FROM bruker WHERE brukernavn=:br";
        $stmtBruker = $db->prepare($sqlBruker);
        $stmtBruker->bindParam(':br',$brukerRapportert);
        $stmtBruker->execute();

        if($stmtBruker->rowCount()){
            while($row = $stmtBruker->fetch(PDO::FETCH_ASSOC)){
                $rap =$row['idbruker'];
            }
        }

        // legg inn i database
        $sql ="INSERT INTO brukerrapport (tekst,rapportbuker,rapportertav,dato) VALUES(:tk,:rb,:ra,NOW())";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':tk',$beskirvelse);
        $stmt->bindParam(':rb',$rap);
        $stmt->bindParam(':ra',$_SESSION['idbruker']);
        $stmt->execute();

        if($stmt->rowCount()){
            echo "Rapportert";
        } else {
            echo "Feil";
        }
    } else {
        header("Location: ../default.php");
    }
?>