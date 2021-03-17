<?php
//Kode skrevet Sigve kontrollert av Erlend og Sanan
	include("../Include/db_pdo.php");
    session_start();
    if(isset($_POST['knapp']) and $_POST['knapp'] == "sjekk") {
        //Sjekker om brukernavn og email stemmer
        $bruker = $_POST['brukernavn'];
        $epost = $_POST['email'];
        $headers = "From: Greentalk@green.com";

        $sql = "SELECT brukernavn, epost
                FROM `bruker`
                WHERE (brukernavn = :br) AND (epost = :ep)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':br', $bruker);
        $stmt->bindParam(':ep', $epost);
        $stmt->execute();

        //Funksjon for å lage tilfeldig ord som nytt passord for brukeren og lager en melding med det.
        function tilfeldigOrd($len = 7) {
            $ord = array_merge(range('a', 'z'), range('A', 'Z'));
            shuffle($ord);
            return substr(implode($ord), 0, $len);
        }
        $tilfeldig = tilfeldigOrd();
        $melding = "Dette er ditt nye passord: ";
        $melding .= $tilfeldig;
        $melding .= " Du kan endre passordet ditt under 'Min Side'";

        mail($epost, "Tilbakestilling av Greentalk passord", $melding, $headers);

        //Salter og hasher det nye passordet
        $passord = sha1($salt.$tilfeldig);
        //Oppdaterer databasen med det nye passordet
        $sql2 = 'UPDATE bruker SET passord =:pw WHERE brukernavn = :br';
        $stmt2 = $db->prepare($sql2);
        $stmt2->bindParam(':pw', $passord);
        $stmt2->bindParam(':br', $bruker);
        $stmt2->execute();

        if($stmt->rowCount()) {
            //mail($epost, "Tilbakestilling av Greentalk passord", $melding);
            header("Location: ../logginn.php");
        } else {echo('Det har oppstått en feil');}
    }
?>