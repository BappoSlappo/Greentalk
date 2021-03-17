<?php
    session_start();
    include("../Include/db_pdo.php");
    include("../Include/sjekkLovAdmin.php");
    // Sjekk om bruker har bruk for å være inne på siden (Siden er bare en action side og skal ikke kunne nås av bruker normalt sett)
    if(isset($_POST['brukerValgte'])){

        $bruker = $_POST['brukerValgte'];
        $tekst = $_POST['advarselTekst'];
        
        // Burder helst egentlig kunne lagret date i databasen
        $tekst = date("Y-m-d H:i:s")."<br> ".$tekst;

        $rap ="";

        // Finne id
        $sqlBruker = "SELECT idbruker FROM bruker WHERE brukernavn=:br";
        $stmtBruker = $db->prepare($sqlBruker);
        $stmtBruker->bindParam(':br',$bruker);
        $stmtBruker->execute();

        if($stmtBruker->rowCount()){
            while($row = $stmtBruker->fetch(PDO::FETCH_ASSOC)){
                $rap =$row['idbruker'];
            }
        }

        // Legger inn advarsel i db
        $sql = "INSERT INTO advarsel (advarseltekst,bruker,administrator) VALUES(:att,:br,:ad)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':att', $tekst);
        $stmt->bindParam(':br', $rap);
        $stmt->bindParam(':ad', $_SESSION['idbruker']);
        $stmt->execute();

            if($stmt->rowCount()){
                echo "Funker";
                header('Location: ../administrasjon.php');
            } else {
                echo "Feil";
            }
    } else{
        header("Location: ../default.php");
    }
?>