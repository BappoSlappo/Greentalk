<?php
    include('../Include/db_pdo.php');
    session_start();
    include("../Include/sjekkLovAdmin.php");
    
    // Sjekk om bruker har bruk for å være inne på siden (Siden er bare en action side og skal ikke kunne nås av bruker normalt sett)
    if(isset($_POST['tekstRegel'])){
        $regel= $_POST['tekstRegel'];

        echo $_SESSION['brukerid'];

        $sql = "INSERT INTO regel (regeltekst, idbruker) VALUES(:rt,:br)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':rt',$regel);
        $stmt->bindParam(':br', $_SESSION['idbruker']);
        $stmt->execute();

        if($stmt->rowCount()){
            echo "Registrert";
            header('Location: oppdaterRegel.php');
        } else {
            echo "Feil";
        }
    } else {
        header("Location: ../default.php");
    }

?>