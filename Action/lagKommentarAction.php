<?php
    include('../Include/db_pdo.php');
    session_start();
    include('../Include/sjekkLov1.php');
    
    // Sjekk om bruker har bruk for å være inne på siden (Siden er bare en action side og skal ikke kunne nås av bruker normalt sett)
    if(isset($_POST['tekst'])){

        // Henter fra skjema
        $tekst = $_POST['tekst'];
        $artId = $_POST['artID'];

        $sql ="INSERT INTO kommentar (tekst, tid, artikkel, bruker) VALUES(:tk, NOW(), :ar, :br)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':tk', $tekst);
        $stmt->bindParam(':ar', $artId);
        $stmt->bindParam(':br', $_SESSION['idbruker']);
        $stmt->execute();

        if($stmt->rowCount()){
            header('Location: ../default.php');
        } else {
            echo "Feil";
        }
    } else {
        header("Location: ../default.php");
    }












?>
