<?php
    include('../Include/db_pdo.php');
    session_start();
    include('../Include/sjekkLov1.php');
    // Sjekk om bruker har bruk for å være inne på siden (Siden er bare en action side og skal ikke kunne nås av bruker normalt sett)
    if(isset($_POST['arrValg'])){
        $status = $_POST['arrValg'];
        $eventId = $_POST['knappen'];
    
        // 0 = skal
        // 1 = intressert
        // 2 = kan ikke
        $itVar = "";

        // Sjekker om påmelding finnes
        $sqlSjekk = "SELECT bruker_id FROM påmelding WHERE bruker_id =:br AND event_id =:ev";
        $stmtSjekk = $db->prepare($sqlSjekk);
        $stmtSjekk->bindParam(':br', $_SESSION['idbruker']);
        $stmtSjekk->bindParam(':ev', $eventId);
        $stmtSjekk->execute();

        echo $stmtSjekk->rowCount();
        // Hvis den finnes
        if($stmtSjekk->rowCount()){
            
            if($status == 0) {
                $itVar = "Skal";
            } else if ($status == 1){
                $itVar = "Interessert";
            } else if ($status == 2) {
                $itVar = "Kan ikke";
            }
            echo "Finnes: ".$itVar;

            $sqlUpdate = "UPDATE påmelding SET interessert =:it WHERE bruker_id = :br AND event_id = :ev";
            $stmtUpdate = $db->prepare($sqlUpdate);
            $stmtUpdate->bindParam(':it', $itVar);
            $stmtUpdate->bindParam(':br', $_SESSION['idbruker']);
            $stmtUpdate->bindParam(':ev', $eventId);
            $stmtUpdate->execute();

            if($stmtUpdate->rowCount()) {
                echo "<img src='https://i.kym-cdn.com/photos/images/newsfeed/001/170/001/c44.png'>";
                echo "Update";
            }
        } else {
            // Finnes ikke
            if($status == 0) {
                $itVar = "Skal";
            } else if ($status == 1){
                $itVar = "Interessert";
            } else if ($status == 2) {
                $itVar = "Kan ikke";
            }
            echo "Ikke: ".$itVar." ".$status;
            
            $sqlArr = "INSERT INTO påmelding VALUES(:ev, :br, :itr)";
            $stmtArr = $db->prepare($sqlArr);
            $stmtArr->bindParam(':ev', $eventId);
            $stmtArr->bindParam(':br', $_SESSION['idbruker']);
            $stmtArr->bindParam(':itr', $itVar);
            $stmtArr->execute();
            
            if($stmtArr->rowCount()) {
                echo "<img src='https://i.kym-cdn.com/photos/images/newsfeed/001/170/001/c44.png'>";
                echo "Insert";
            } else {
            }


        }
        header("Location: ../default.php");
    } else{
        
    }
?>