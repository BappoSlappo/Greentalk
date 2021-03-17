<?php
    session_start();
    include("../Include/db_pdo.php");
    include("../Include/sjekkLovAdmin.php");
    // Sjekk om bruker har bruk for å være inne på siden (Siden er bare en action side og skal ikke kunne nås av bruker normalt sett)
    if(isset($_POST['brukernavn'])){

        $bruker = $_POST['brukernavn'];
        $rolle = $_POST['tittel'];

        // Oppdaterer rollen til brukeren
        // Sjekker at verdien er lovlig
        if($rolle != 3 or $rolle != 4){
            $sql = "UPDATE bruker SET brukertype=:bt WHERE brukernavn=:br";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':bt', $rolle);
            $stmt->bindParam(':br', $bruker);
            $stmt->execute();

            if($stmt->rowCount()){
                echo "Oppdatert";
                header('Location: ../administrasjon.php');
            } else {
                echo "Feil";
            }
        }
    }
    else {
        header("Location: ../default.php");
    }
        
?>
