<?php
    //Laget av Erlend, kontrollert i fellesskap
    include("Include/db_pdo.php");
    include('Header/header.php');
    include('Include/sjekkLov1Hovedsider.php');
    // Får inn datan fra interessen det gjelder
    // Hvis knapper for å slette er trykket
    if(isset($_POST['to'])){
        $inter = $_POST['to'];

        $svar = finnInteresseId($db,$inter);

        // Henter id for interesse
        $sql = "SELECT idinteresse FROM interesse WHERE interessenavn = :na";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':na', $inter);
        $stmt->execute();

        $idint;
        if($stmt->rowCount()) {
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $idint = $row['idinteresse'];
            }
        }

        $sql = "DELETE FROM brukerinteresse WHERE bruker =:br AND interesse =:inte";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':br', $_SESSION['idbruker']);
        $stmt->bindParam(':inte', $idint);
        $stmt->execute();

        if($stmt->rowCount()) {
            echo "Slettet";
            header('Location: minSide.php');

        } else {
            echo "Feil";
        }

        // Hvis knappen for å finne andre med samme interesser er trykket
    } elseif (isset($_POST['visAndre'])){
        $_SESSION['idinteresse'] = finnInteresseId($db,$inter);
        $_SESSION['sokInt'] = $_POST['visAndre'];
        

        header('Location: interesser.php');
    }
    elseif (isset($_POST['sokbar'])) {
        $_SESSION['idinteresse'] = finnInteresseId($db,$_POST['sok']);
        $_SESSION['sokInt'] = $_POST['sok'];
        header('Location: interesser.php');
    }

    // Funksjon for å finne id til interessen
    function finnInteresseId($db, $inter) {
            // Henter id for interesse
            $sql = "SELECT idinteresse FROM interesse WHERE interessenavn = :na";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':na', $inter);
            $stmt->execute();
        
            $idint;
            if($stmt->rowCount()) {
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $idint = $row['idinteresse'];
                }
            }
            return $idint;

    }
?>
    <?php
        include("../Include/tilbake.php");
    ?>