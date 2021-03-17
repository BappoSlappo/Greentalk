<?php
    include('../Include/db_pdo.php');
    session_start();
    include('../Include/sjekkLov2.php');

    $arrNavn = $_POST['overskrift'];
    $beskrivelse = $_POST['artigress'];
    $veiBeskriv = $_POST['veiBes'];
    $tid = $_POST['tidinn'];
    $fylke = $_POST['fylke'];

    // bilde sjekk
    $mappe = "../Bilder/";
    $mappeMini="../Bilder/Miniatyr/";

    // Legger inn i db
    $sql= "INSERT INTO `event` (eventnavn, eventtekst, tidspunkt, veibeskrivelse, idbruker, fylke) VALUES(:en, :et, :tp, :vb, :br, :fl)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':en', $arrNavn);
    $stmt->bindParam(':et', $beskrivelse);
    $stmt->bindParam(':tp', $tid);
    $stmt->bindParam(':vb', $veiBeskriv);
    $stmt->bindParam(':br', $_SESSION['idbruker']);
    $stmt->bindParam(':fl', $fylke);
    $stmt->execute();

    if($stmt->rowCount()) {
      
        $sisteIdArt = $db->lastInsertId();
        $mappeLagre = "Bilder/ArtArr/";
        $mappeen = "../Bilder/ArtArr/";
        $target_file = $mappeLagre .$sisteIdArt ."arrangement." .basename($_FILES['bildeInn']['type']);
        $target_file2 = $mappeen .$sisteIdArt ."arrangement." .basename($_FILES['bildeInn']['type']);
        
        $data = file_get_contents($_FILES['bildeInn']['tmp_name']);
        $type = basename($_FILES['bildeInn']['type']);
        
        $uploadOk=1;
          // Check file size
          if ($_FILES["bildeInn"]["size"] > 500000000) {
             echo "Sorry, your file is too large.";
             $uploadOk = 0;
         }
         // Allow certain file formats
         if($type != "jpg" && $type != "png" && $type != "jpeg") {
             echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
             $uploadOk = 0;
         }
         // Check if $uploadOk is set to 0 by an error
         if ($uploadOk == 0) {
             echo "Sorry, your file was not uploaded.";
         // if everything is ok, try to upload file
         } else {
             // Sjekker om profilbilde finnes fra før
        echo $target_file;
        if(move_uploaded_file($_FILES["bildeInn"]["tmp_name"], $target_file2)){
        
     
         // Legg inn bilde i db
         $sqlbilde = "INSERT INTO bilder (hvor) VALUES(:hv)";
         $stmtBilde = $db->prepare($sqlbilde);
         $stmtBilde->bindParam(':hv', $target_file);
         $stmtBilde->execute();
         $sisteIdbilde = $db->lastInsertId();
     
         $sql2 = "INSERT INTO eventbilde (event, bilde) VALUES(:ar, :bl)";
     
         $stmt2 = $db->prepare($sql2);
         $stmt2->bindParam(':ar', $sisteIdArt);
         $stmt2->bindParam(':bl', $sisteIdbilde);
         $stmt2->execute();

        // Thumbnail
        $percent =.5;
        $filname = $target_file2;
        //echo $filname;

        //header('Content-Type: image/jpeg');
        list($width, $height) = getimagesize($filname);
        $new_width = $width * $percent;
        $new_height = $height * $percent;

        // resample
        $thumbnail =imagecreatetruecolor($new_width, $new_height);
        $virkeligbilde;

        // Finn rett type 
        if($type == "jpg" || $type == "jpeg"){
        $virkeligbilde = imagecreatefromjpeg($filname);
        }else if ($type == "png"){
        $virkeligbilde = imagecreatefrompng($filname);
        }


        $bildenavn = "../Bilder/Miniatyr/".$sisteIdArt."minibildeArr.".$type;
        $bildenavn2 = "Bilder/Miniatyr/".$sisteIdArt."minibildeArr.".$type;
        imagecopyresampled($thumbnail, $virkeligbilde, 0,0,0,0, $new_width, $new_height, $width, $height);
        imagejpeg($thumbnail, $bildenavn, 50);
        // Finner rett bilde type
        if($type == "jpg"){
            imagejpeg($thumbnail, $bildenavn, 50);
        }else if ($type == "png"){
            imagepng($thumbnail, $bildenavn, 5);
        }

        // Legg inn miniatyr bildetbilde i db
        $sqlbilde = "INSERT INTO bilder (hvor) VALUES(:hv)";
        $stmtBilde = $db->prepare($sqlbilde);
        $stmtBilde->bindParam(':hv', $bildenavn2);
        $stmtBilde->execute();
        $sisteIdbilde = $db->lastInsertId();

        $sql3 = "INSERT INTO eventbilde (event, bilde) VALUES(:ar, :bl)";

        $stmt3 = $db->prepare($sql3);
        $stmt3->bindParam(':ar', $sisteIdArt);
        $stmt3->bindParam(':bl', $sisteIdbilde);
        $stmt3->execute();
        echo "<br>";

        if($stmt2->rowCount()){
            echo"funker";
        } else {
            echo "feil";
        }









     }
     













         header('Location: ../default.php');
        }
  header('Location: ../default.php');
}

    ?>