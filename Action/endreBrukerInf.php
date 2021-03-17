<?php
    include('../Include/db_pdo.php');
    session_start();
    include("../Include/sjekkLov1.php");
    // Sjekk om bruker har bruk for å være inne på siden (Siden er bare en action side og skal ikke kunne nås av bruker normalt sett)
    if(isset($_POST['fornavn'])){

        $fnavnI = $_POST['fornavn'];
        $enavnI = $_POST['etternavn'];
        $tlfI = $_POST['tlf'];

    // echo $fnavn." ". $enavn;
        echo $_SESSION['idbruker'];

        $sql = "UPDATE bruker SET fnavn = :fn, enavn = :en, telefonnummer = :tl WHERE idbruker = :br";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':fn', $fnavnI);
        $stmt->bindParam(':en', $enavnI);
        $stmt->bindParam(':tl', $tlfI);
        $stmt->bindParam(':br', $_SESSION['idbruker']);
        $stmt->execute();

        $fnavn =0;
        $enavn =0;
        $epost=0;
        $tlf=0;
        $int=0;
        $bes=0;
        
        if (isset($_POST['fnavnVis'])) {
            $fnavn = 1;
        };

        if(isset($_POST['enavnVis'])) {
            $enavn = 1;
        };
        if(isset($_POST['epostVis'])) {
            $epost = 1;
        };

        if(isset($_POST['tlfVis'])) {
            $tlf =1;
        };

        if(isset($_POST['intVis'])) {
            $int =1;
        };
        if(isset($_POST['besVis'])) {
            $bes =1;
        };

        $sqlP = "UPDATE preferanse SET visfnavn=:fn, visenavn=:en, visepost=:ep, vistelefonnummer=:tl, visinteresser =:it, visbeskrivelse=:bs WHERE bruker = :br";
        $stmtP = $db->prepare($sqlP);
        $stmtP->bindParam(':fn', $fnavn);
        $stmtP->bindParam(':en', $enavn);
        $stmtP->bindParam(':ep', $epost);
        $stmtP->bindParam(':tl', $tlf);
        $stmtP->bindParam(':it', $int);
        $stmtP->bindParam(':bs', $bes);
        $stmtP->bindParam(':br', $_SESSION['idbruker']);
        $stmtP->execute();
        
        if($stmt->rowCount()) {
            $_SESSION["fornavn"] = $fnavnI;
            header('Location: ../minside.php');
        } else {
            header('Location: ../minside.php');
        }
    }else{
        header("Location: ../default.php");
    }
?>