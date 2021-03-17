<?php
    include('../Include/db_pdo.php');
    session_start();
    include('../Include/sjekkLov1.php');
    $mappeLagre = "../Bilder/";
    $mappeDatabase = "Bilder/";

    $target_file = $mappeLagre .$_SESSION['idbruker']."profilbilde.". basename($_FILES['bildeInn']['type']);
    $target_fileDatabase = $mappeDatabase .$_SESSION['idbruker']."profilbilde.". basename($_FILES['bildeInn']['type']);
    $data = file_get_contents($_FILES['bildeInn']['tmp_name']);
    $type = basename($_FILES['bildeInn']['type']);

    echo "basename: ".basename($_FILES['bildeInn']['type']."<br>");
    echo $target_fileDatabase."<br>";
    $uploadOk = 1;
    $bildeFilType = strtolower(pathinfo($target_fileDatabase, PATHINFO_EXTENSION));
    
    if(isset($_POST['submit'])) {
        $check = getimagesize($_FILES["bildeInn"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

    // Finn bilde størelse
    if ($_FILES["bildeInn"]["size"] > 50000000000) {
        echo "Filen er for stor.";
        $uploadOk = 0;
    }
    // Sjekk filtype
    if($type != "jpg" && $type != "png" && $type != "jpeg") {
        echo "Bare JPG, JPEG og PNG filer kan lastes opp";
        $uploadOk = 0;
    }
    // Sjekk om alt er ok
    if ($uploadOk == 0) {
        echo "Filen kunne ikke lastes opp.";
    // 
    } else {
        // Sjekker om profilbilde finnes fra før

        $sql = "SELECT bilde FROM brukerbilde WHERE bruker = :br";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':br', $_SESSION['idbruker']);
        $stmt->execute();

        if($stmt->rowCount()) {
            $idBildet;
            while($rad = $stmt->fetch(PDO::FETCH_ASSOC)){
                $idBildet = $rad['bilde'];
            }
            // Bilde finnes
            $sql = "UPDATE bilder SET hvor = :hv WHERE idbilder = :bl";
            lagBilde($sql,$db, $target_fileDatabase,$idBildet,$target_file);

        } else {
            // Bilde finnes ikke
            $sql = "INSERT INTO bilder (hvor) VALUES(:hv)";
            lagBilde($sql,$db, $target_fileDatabase,$idBildet,$target_file);
        } 
    }

    function lagBilde($sql, $db, $target_fileDatabase,$idBildet,$target_file) {
        if (move_uploaded_file($_FILES["bildeInn"]["tmp_name"], $target_file)) {
           // echo "The file ". basename( $_FILES["bildeInn"]["name"]). " has been uploaded.";

            $stmt = $db->prepare($sql);
            $stmt->bindParam(':hv', $target_fileDatabase);
            if(isset($idBildet)){
                $stmt->bindParam(':bl', $idBildet);
            }
            $stmt->execute();

            $sisteId = $db->lastInsertId();
            $idbruker = $_SESSION['idbruker'];

            if($stmt->rowCount()) {
                echo "<br>";
                echo $sisteId;
                echo $idbruker;
                echo "<br>";

                $sql2 = "INSERT INTO brukerbilde (bruker, bilde) VALUES(:br, :bl)";

                $stmt2 = $db->prepare($sql2);
                $stmt2->bindParam(':br', $idbruker);
                $stmt2->bindParam(':bl', $sisteId);
                $stmt2->execute();
                
                echo "<br>Idbruker: ".$idbruker;
                echo "<br>Idbilde: ".$sisteId."<br>";
                echo "<br> stmt2: ".$stmt2->execute()."<br>";

                if($stmt2->rowCount()) {
                    echo "Lastet opp";
                    header('Location: ../minside.php');
                } else {
                    echo "<br>Feil<br>";
                   header('Location: ../minside.php');
                }
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
header('Location: ../minside.php');

?>
    <?php
        include("../Include/tilbake.php");
    ?>