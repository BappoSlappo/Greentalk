<?php
    include('Include/db_pdo.php');
    session_start();

    $sql = "SELECT COUNT(*) AS Antall FROM melding WHERE melding.mottaker = :br AND lest =0";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':br', $_SESSION['idbruker']);
    $stmt->execute();

    if($stmt->rowCount()){
        while($rad=$stmt->fetch(PDO::FETCH_ASSOC)){
            echo "Meldinger: " .$rad['Antall'];
            
        }
    }
?>