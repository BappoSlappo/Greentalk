<?php
    session_start();
    include('../Include/db_pdo.php');
    include("../Include/sjekkLov1.php");
    $liste =array();
    $sql = "SELECT interessenavn FROM interesse GROUP BY interessenavn";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    if($stmt->rowCount()) {
        while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
            // Sjekker om verdien er tom
            if($row['interessenavn'] != ""){
                $liste[] = $row['interessenavn'];
            }
            
        }
    }
    

    $q = $_REQUEST["q"];
    
    $hint = "";
    if($q !== "") {
        $q= strtolower($q);
        $len=strlen($q);

        foreach($liste as $name) {
            if (stristr($q, substr($name, 0, $len))) {
                if ($hint === "") {
                    $in = '"'.$name.'"';
                    $hint = "<button type='submit' class='tester' name='addNy' value='".$name."' onclick='endre(".$in.")'>".$name."</button>";
                } else {
                    $in = '"'.$name.'"';
                    $hint .= "<button type='submit' class='tester' name='addNy' value='".$name."'onclick='endre(".$in.")'>".$name."</button>";
                }
              }
            }
        echo $hint;
        }

    include('../Include/footer.php');
?>
