<?php
    include("Include/db_pdo.php");
    include('Header/header.php');
    include("Include/sjekkLovAdminHovedsider.php");
?>
<!DOCTYPE html>
<html>
<!-- Laget av Stian -->
<main id="brukerRapport">
    <p>Trykk på "Brukernavn" eller "Epost" for å sortere </p>
    <p>Trykk på brukenavnene for å få opp detaljer om tidligere misbruk</p>
    <section id="rapportTabell">
        <table id="utTest">
        <table id='rapportTable'>
            <tr>
                <th onclick="sorterTabell(0)" class="klikkTabell">Brukernavn</th>
                <th>Navn</th>
                <th onclick="sorterTabell(1)" class="klikkTabell">Epost</th>
                <th>Antall misbruk</th>
                <th>Status</th>
            </tr>

            <?php
                // printer ut alle brukere
                $sql ="SELECT brukernavn, fnavn, enavn, brukertypenavn, idbruker,epost FROM bruker, brukertype WHERE bruker.brukertype = brukertype.idbrukertype";
                $stmt = $db->prepare($sql);
                $stmt->execute();

                if($stmt->rowCount()){
                    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
                        echo "
                            <tr>
                                <td onclick='lagmindreRapport(this.innerHTML)' class='klikkTabell'>".$row['brukernavn']."</td>
                                <td>".$row['fnavn']." ".$row['enavn']."</td>
                                <td>".$row['epost']."</td>
                        ";

                        $sqlAntall="SELECT * FROM misbruk WHERE bruker=:br";
                        $stmtAntall = $db->prepare($sqlAntall);
                        $stmtAntall->bindParam(':br',$row['idbruker']);
                        $stmtAntall->execute();

                        if($stmtAntall->rowCount()){
                            echo "<td>".$stmtAntall->rowCount()."</td>";
                        } else {
                            echo "<td>0</td>";
                        }
                        
                        echo "<td>".$row['brukertypenavn']."</td>
                        </tr>
                        ";
                    }
                }
            
            ?>
        </table>
        </table>
    </section>
</main>
<?php
include('Include/footer.php');
?>
</html>