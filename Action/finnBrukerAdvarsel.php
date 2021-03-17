<?php
session_start();
    include('../Include/db_pdo.php');
    include("../Include/sjekkLovAdmin.php");

    $liste =array();
    $sql = "SELECT brukernavn FROM bruker, brukerrapport WHERE bruker.idbruker = brukerrapport.rapportbuker GROUP BY brukernavn";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    if($stmt->rowCount()) {
        while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
            // Sjekker om verdien er tom
            if($row['brukernavn'] != ""){
                $liste[] = $row['brukernavn'];
            }
            
        }
    }

    $q = $_REQUEST["brukernavn"];
    
    $hint = "";
    if($q !== "") {
        $q= strtolower($q);
        $len=strlen($q);

        foreach($liste as $name) {
            if (stristr($q, substr($name, 0, $len))) {
                if ($hint === "") {
                    $in = '"'.$name.'"';
                    $hint = "<button type='submit' class='tester' name='addNy' value='".$name."' onclick='settBruker(".$in.")'>".$name."</button>";
                } else {
                    $in = '"'.$name.'"';
                    $hint .= "<button type='submit' class='tester' name='addNy' value='".$name."'onclick='settBruker(".$in.")'>".$name."</button>";
                }
              }
            }
        echo $hint;
        }

    include('../Include/footer.php');








?>