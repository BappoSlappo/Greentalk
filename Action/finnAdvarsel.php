<?php
    session_start();
    include('../Include/db_pdo.php');
    include("../Include/sjekkLovAdmin.php");
    $brukernavn = $_GET['brukernavn'];
    $liste = "";


    $rap ="";

    // Finne id
    $sqlBruker = "SELECT idbruker FROM bruker WHERE brukernavn=:br";
    $stmtBruker = $db->prepare($sqlBruker);
    $stmtBruker->bindParam(':br',$brukernavn);
    $stmtBruker->execute();

    if($stmtBruker->rowCount()){
        while($row = $stmtBruker->fetch(PDO::FETCH_ASSOC)){
            $rap =$row['idbruker'];
        }
    }

    $sql = "SELECT tekst, dato, brukernavn FROM brukerrapport,bruker WHERE rapportbuker=:br AND idbruker=rapportertav";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':br',$rap);
    $stmt->execute();

    // finner tid mellom de to siste rapporteringene
    $rap1 ="";
    $rap2 = "";
    $antall = 1;
    if($stmt->rowCount()){
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            if($antall == $stmt->rowCount()-1){
                $rap1 = $row['dato'];
            } else if($antall == $stmt->rowCount()){
                $rap2 = $row['dato'];
            }
            echo "<article class='rappo'>"."<p>".$row['tekst']."<br>".$row['brukernavn']."<br>".$row['dato']."</p></article>";
            
            $antall++;
        }
    }
    $rap1 = new DateTime($rap1);
    $rap2 = new DateTime($rap2);
    $forskjell = $rap1->diff($rap2);
    echo "Det er ".$forskjell->y." år, ".$forskjell->m;
    
    if($forskjell->m !=1){
        echo " måneder";
    }else {
        echo " måned";
    }
    echo" og ";
    echo $forskjell->d;
    if($forskjell->d !=1){
        echo " dager ";
    } else {
        echo " dag ";
    }
    echo "mellom de to siste rapporteringene<br>";

    // Printer ut knapp for å eksludere hvis det er liten nok tid imellom rapportene
    if($forskjell->days <=30){
        $inn = '"'.$rap.'"';
        echo"<input type='button' value='Ekskluder' onclick=ekskluder(".$inn.")>";
    }

?>