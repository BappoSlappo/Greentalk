<?php
    include('../Include/db_pdo.php');
    session_start();
    $fnavn =1;
    $enavn =1;
    $epost=1;
    $tlf=1;
    if(isset($_POST['fnavn'])){

        if (isset($_POST['fnavn'])) {
            $fnavn = 0;
        };

        if(isset($_POST['enavn'])) {
            $enavn = 0;
        };
        if(isset($_POST['epost'])) {
            $epost = 0;
        };

        if(isset($_POST['tlf'])) {
            $tlf =0;
        };

        $sql = "UPDATE preferanse SET visfnavn=:fn, visenavn=:en, visepost=:ep, vistelefonnummer=:tl WHERE bruker = :br";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':fn', $fnavn);
        $stmt->bindParam(':en', $enavn);
        $stmt->bindParam(':ep', $epost);
        $stmt->bindParam(':tl', $tlf);
        $stmt->bindParam(':br', $_SESSION['idbruker']);
        $stmt->execute();
        
        if($stmt->rowCount()) {
        
            header('Location: ../minside.php');
        }
    } else {
        header("Location: ../default.php");
    }
        
?>