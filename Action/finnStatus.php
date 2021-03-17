<?php
    session_start();
    include('../Include/db_pdo.php');
    include("../Include/sjekkLovAdmin.php");
    // Sjekk om bruker har bruk for å være inne på siden (Siden er bare en action side og skal ikke kunne nås av bruker normalt sett)
    if(isset($_GET['brukernavn'])){
        $brukernavn = $_GET['brukernavn'];

        $sql = "SELECT brukertypenavn FROM bruker, brukertype WHERE bruker.brukertype = brukertype.idbrukertype AND bruker.brukernavn = :br";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':br', $brukernavn);
        $stmt->execute();
        echo "Status: ";
        if($stmt->rowCount()){
            while($rad = $stmt->fetch(PDO::FETCH_ASSOC)){
                echo $rad['brukertypenavn'];
            }
        } else {
            echo "feil";
        }
    } else{
        header("Location: ../default.php");
    }

?>