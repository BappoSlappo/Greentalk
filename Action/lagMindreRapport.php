<?php
    session_start();
    include('../Include/db_pdo.php');
    include('../Include/sjekkLovAdmin.php');
    // Sjekk om bruker har bruk for å være inne på siden (Siden er bare en action side og skal ikke kunne nås av bruker normalt sett)
    if(isset($_GET['brukernavn'])){
        $brukernavn = $_GET['brukernavn'];


        $sql ="SELECT misbruk.* FROM misbruk, bruker WHERE bruker.idbruker=misbruk.bruker AND bruker.brukernavn = :br";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':br', $brukernavn);
        $stmt->execute();
        
        if($stmt->rowCount()){
            echo "   <tr>
            <th>Tekst</th>
            <th>Rapportert av</th>
        </tr>";
            while($row =$stmt->fetch(PDO::FETCH_ASSOC)){
                echo"<tr>";
                echo "<td>".$row['tekst']."</td>
                        <td>".$row['bruker']."</td>
                        </tr>";
            }
        } else {
            echo "Ingen registrerte misbruk";
        }
    } else {
        header("Location: ../default.php");
    }

?>