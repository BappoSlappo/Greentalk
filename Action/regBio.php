<?php
    include('../include/db_pdo.php');
    session_start();
    include('../Include/sjekkLov1.php');
    // Sjekk om bruker har bruk for å være inne på siden (Siden er bare en action side og skal ikke kunne nås av bruker normalt sett)
    if(isset($_POST['tekst'])){
        $biografi = $_POST['tekst'];

        $sql = "UPDATE bruker SET beskrivelse =:te WHERE brukernavn =:br";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':te', $biografi);
        $stmt->bindParam(':br', $_SESSION['bruker']);

        $stmt->execute();

        if($stmt->execute()) {
            header('Location: ../minside.php');
            // Legg inn melding om suksess
        } else {
            header('Location: ../minside.php');
            // Legg inn melding om feil
        }
    }else {
        header("Location: ../default.php");
    }
?>
    <?php
        include("../Include/tilbake.php");
    ?>