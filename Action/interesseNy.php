<?php
    // Legger til ny interesse
    include('../Include/db_pdo.php');
    session_start();
    include('../Include/sjekkLov1.php');
    // Sjekk om bruker har bruk for å være inne på siden (Siden er bare en action side og skal ikke kunne nås av bruker normalt sett)
    if(isset($_POST['addNy']) or isset($_POST['interesse'])){
  

        if(isset($_POST['addNy'])){
            $interesse = $_POST['addNy'];
        } else {
            $interesse = $_POST['interesse'];
        }

        echo $interesse;
        // Sjekker om interessen finnes i databasen fra før av
        // Legg til sjekk om bruker har interessen allerede registrert
        $sql = "SELECT interessenavn FROM interesse WHERE interessenavn = :int";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':int', $interesse);
        $stmt->execute();

        if($stmt->rowCount()) {
            echo "Interessen er allerede registrert";
            regBrukerInt($db, $interesse);
        } else {
            echo "Interessen er ikke registrert <br><br>";


            // Hvis interessen ikke er registrert fra før
            $sql = "INSERT INTO interesse (interessenavn) VALUES (:int)";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':int', $interesse);
            $stmt->execute();

            if($stmt->rowCount()) {
                echo "Interessen " . $interesse . " ble registrert";
                // Interessen blir registret
                regBrukerInt($db,$interesse);

            } else {
                echo "Interessen ble ikke registrert";
            }
        }

        // Funksjon for å legge til interessen til brukeren

    }
    else{
        header("Location: ../default.php");
    }

    function regBrukerInt($no, $interesse){
        // Henter ut idinteresse fra interessen med navnet
        $sql = "SELECT idinteresse FROM interesse WHERE interessenavn = :int";
        $stmt = $no->prepare($sql);
        $stmt->bindParam(':int', $interesse);
        $stmt->execute();

        $idinteresse = "";
        echo "<br>no";
        if($stmt->execute()) {
            echo "<br>her";
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $idinteresse =$row['idinteresse'];
            }
        }

        echo "<br> Int: ".$idinteresse;

        
        // Legger til brukerinteressen
        $sql = "INSERT INTO brukerinteresse VALUES (:br, :int)";
        $stmt = $no->prepare($sql);
        $stmt->bindParam(':br', $_SESSION['idbruker']);
        $stmt->bindParam(':int', $idinteresse);
        $stmt->execute();

        if($stmt->rowCount()) {
        header('Location: ../minside.php');
        } else {
        header('Location: ../minside.php');
        }       
    }
?>