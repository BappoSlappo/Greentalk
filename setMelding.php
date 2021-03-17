<?php
// Laget av Sigve, kontrollert i fellesskap
    include('Include/db_pdo.php');
    session_start();
    $idmelding= $_GET['idmelding'];

    $sql = "SELECT tittel, tekst, brukernavn, lest, papirkurv, tid FROM melding, bruker WHERE idmelding = :id AND bruker.idbruker = :br";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $idmelding);
    $stmt->bindParam(':br',$_SESSION['idbruker']);
    $stmt->execute();

    if($stmt->rowCount()){
        $lest = 1;
        while($rad = $stmt->fetch(PDO::FETCH_ASSOC)){
            $lest = $rad['lest'];
            echo "<h2>".$rad['tittel']."</h2>
                  <p>".$rad['tekst']."</p>
                  <p>".$rad['tid']."</p>
            ";
        }
        if($lest == 0) {
            // Oppdaterer lest
            $sqlLest = "UPDATE melding SET lest=1 WHERE idmelding=:id AND mottaker = :br";
            $stmtLest = $db->prepare($sqlLest);
            $stmtLest->bindParam(':id',$idmelding);
            $stmtLest->bindParam(':br',$_SESSION['idbruker']);
            $stmtLest->execute();
        }
    }
?>