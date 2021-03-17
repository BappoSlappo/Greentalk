<?php
    include('../Include/db_pdo.php');
    session_start();
    include('../Include/sjekkLov2.php');
   $overskrift =  $_POST['overskrift'];
   $artigress = $_POST['artigress'];
   $bilde = file_get_contents($_FILES['bildeInn']['tmp_name']);
   $artitekst = $_POST['tekst'];

   echo $overskrift."<br>".$artigress. "<br>" .$artitekst."<br>".$_SESSION['idbruker']."<br>";
   // Legger til artikkel
   $sql = "INSERT INTO artikkel (artnavn, artingress, arttekst, bruker) VALUES (:an, :ag, :at, :br)";
   $stmt = $db->prepare($sql);
   $stmt->bindParam(':an', $overskrift);
   $stmt->bindParam(':ag', $artigress);
   $stmt->bindParam(':at', $artitekst);
   $stmt->bindParam(':br', $_SESSION['idbruker']);
   $stmt->execute();

   if($stmt->rowCount()) {
       echo "Registrert ";
   }else {
       echo "Feil";
   }
   $sisteIdArt = $db->lastInsertId();
   $mappeLagre = "../Bilder/ArtArr/";
   $mappeLagre2 = "Bilder/ArtArr/";
   $target_file = $mappeLagre .$sisteIdArt ."artikkelbilde." .basename($_FILES['bildeInn']['type']);
   $target_file2 = $mappeLagre2 .$sisteIdArt ."artikkelbilde." .basename($_FILES['bildeInn']['type']);
   $data = file_get_contents($_FILES['bildeInn']['tmp_name']);
   $type = basename($_FILES['bildeInn']['type']);
   
$uploadOk=1;
     // Sjekk filstørrelse
     if ($_FILES["bildeInn"]["size"] > 5000000) {
        echo "Filen er for stor.";
        $uploadOk = 0;
    }
    // Sjekk type på bilde
    if($type != "jpg" && $type != "png" && $type != "jpeg") {
        echo "Bare JPEG, PNG og JPG filer kan lastes opp.";
        $uploadOk = 0;
    }
    // Sjekk om alt er ok
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        // Sjekker om profilbilde finnes fra før
   echo $target_file;
   if(move_uploaded_file($_FILES["bildeInn"]["tmp_name"], $target_file)){
   

    // Legg inn hele bildetbilde i db
    $sqlbilde = "INSERT INTO bilder (hvor) VALUES(:hv)";
    $stmtBilde = $db->prepare($sqlbilde);
    $stmtBilde->bindParam(':hv', $target_file2);
    $stmtBilde->execute();
    $sisteIdbilde = $db->lastInsertId();

    $sql2 = "INSERT INTO artikkelbilde (idartikkel, idbilde) VALUES(:ar, :bl)";

    $stmt2 = $db->prepare($sql2);
    $stmt2->bindParam(':ar', $sisteIdArt);
    $stmt2->bindParam(':bl', $sisteIdbilde);
    $stmt2->execute();


     // Thumbnail
     $percent =.5;
     $filname = $target_file;
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
     
    
     $bildenavn = "../Bilder/Miniatyr/".$sisteIdArt."minibildeArt.".$type;
     $bildenavn2 = "Bilder/Miniatyr/".$sisteIdArt."minibildeArt.".$type;
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

    $sql2 = "INSERT INTO artikkelbilde (idartikkel, idbilde) VALUES(:ar, :bl)";

    $stmt2 = $db->prepare($sql2);
    $stmt2->bindParam(':ar', $sisteIdArt);
    $stmt2->bindParam(':bl', $sisteIdbilde);
    $stmt2->execute();



    
}

    header('Location: ../default.php');
   }

   

?>