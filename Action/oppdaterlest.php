<?php
    include("../Include/db_pdo.php");
    session_start();
    include('../Include/sjekkLov1.php');
    // Sjekk om bruker har bruk for å være inne på siden (Siden er bare en action side og skal ikke kunne nås av bruker normalt sett)
    if(isset($_GET['idmelding'])){

        $meldingid = $_GET['idmelding'];
        $lest = 0;
        if ($lest !=1) {
            $sql = "UPDATE melding SET lest=1 WHERE mottaker=:br AND idmelding = :mi";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':br', $_SESSION['idbruker']);
            $stmt->bindParam(':mi', $meldingid);
            $stmt->execute();

            if($stmt->rowCount()) {
                header("location:../melding.php");
            } else {
                header("location:../melding.php");
            }
        }
    } else {
        header("Location: ../default.php");
    }
?>