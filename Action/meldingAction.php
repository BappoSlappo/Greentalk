<?php
	session_start();
	include("../Include/db_pdo.php");
	include('../Include/sjekkLov1.php');
	// Sjekk om bruker har bruk for å være inne på siden (Siden er bare en action side og skal ikke kunne nås av bruker normalt sett)
	if(isset($_GET['mottaker'])){
		$givid = $_GET['mottaker'];
		$sql2 = "SELECT idbruker FROM bruker WHERE brukernavn = :br";
		$stmt2 = $db->prepare($sql2);
		$stmt2->bindParam(':br',$givid);
		$stmt2->execute();

		$mottaker = "";
		if($stmt2->rowCount()) {
			while($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
				$mottaker = $row['idbruker'];
			}
		}

		$tittel = $_GET['tittel'];
		$tekst = $_GET['tekst'];

		$sql3 = "INSERT INTO melding(tittel, tekst, tid, lest, papirkurv, sender, mottaker)";
		$sql3 .= "VALUES(:tl, :tk, NOW(), '0', '0', :br, :mt)";
		$stmt3 = $db->prepare($sql3);
		$stmt3->bindParam(':tl', $tittel);
		$stmt3->bindParam(':tk', $tekst);
		$stmt3->bindParam(':mt', $mottaker);
		$stmt3->bindParam(':br', $_SESSION['idbruker']);
		$stmt3->execute();
		if($stmt3->rowCount()) {
			echo "Sendt";
		} else {
			echo "Feil";
		}
	} else{
		header("Location: ../default.php");
	}
?>