<?php
	if(isset($_SESSION['brukertype'])) {
        if($_SESSION['brukertype']!= 1){
            $tekst = "Forsøk på innbrudd for side du ikke har tilgang på, misbruksrapport er sendt til administrator";
            // Lag advarsel og lag misbruk
            $sql = "INSERT INTO advarsel (advarseltekst,bruker,administrator) VALUES(:tk,:br,1)";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':tk',$tekst);
            $stmt->bindParam(':br',$_SESSION['idbruker']);
            $stmt->execute();

            if($stmt->execute()){
                $tekst2 = "Prøvde å bryte seg inn på admin side";
                $sqlMissbruk = "INSERT INTO misbruk (tekst, bruker) VALUES(:tk,:br)";
                $stmtMissbruk = $db->prepare($sqlMissbruk);
                $stmtMissbruk->bindParam(':tk', $tekst2);
                $stmtMissbruk->bindParam(':br', $_SESSION['idbruker']);
                $stmtMissbruk->execute();

                if($stmtMissbruk->rowCount()){
                    header('Location ../logUt.php');
                }
            }
        }

	} else {
		header('Location: ../logUt.php');
	}

?>