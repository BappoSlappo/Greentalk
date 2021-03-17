<?php
    session_start();
    include('../Include/db_pdo.php');
    include("../Include/sjekkLovAdmin.php");
    // Sjekk om bruker har bruk for å være inne på siden (Siden er bare en action side og skal ikke kunne nås av bruker normalt sett)
    if(isset($_GET['brukernavn'])){
        $brukernavn = $_GET['brukernavn'];
        $rap ="";

        // ekskluder bruker

        $sql = "UPDATE bruker SET brukertype = 4 WHERE idbruker =:br";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':br', $brukernavn);
        $stmt->execute();
        if($stmt->rowCount()){
            echo "Ekskludert";
        } else {
            echo "Feil";
        }
    }else{
        header("Loaction: ../default.php");
    }

    
?>