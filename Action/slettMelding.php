<?php
    session_start();
    include('../Include/db_pdo.php');
    include('../Include/sjekkLov1.php');
    if(isset($_GET['idmelding'])){
        $idmelding = $_GET['idmelding'];
        $type = $_GET['type'];
    
        if($type == 0){
            $sql = "UPDATE melding SET papirkurv=0 WHERE idmelding=:id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id', $idmelding);
            $stmt->execute();
    
        } else{
            $sql = "UPDATE melding SET papirkurv=1 WHERE idmelding=:id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id', $idmelding);
            $stmt->execute();
        }

    } else {
        echo "Nei";
    }
   


?>