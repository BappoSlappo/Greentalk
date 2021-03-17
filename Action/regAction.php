<?php
	include("../Include/db_pdo.php");
	session_start();
	if(isset($_POST['knapp']) and $_POST['knapp'] == "sjekk") {
		$passord = $_POST['passord'];
		$passord2 = $_POST['passord2'];

		if($passord == $passord2) {

			$brukernavn =$_POST['brukernavn'];
			$epostadresse = $_POST['email'];
			$fnavn = $_POST['fnavn'];
			$enavn = $_POST['enavn'];
			$brukertype = 3;
			$passord = sha1($salt.$passord);
			$tlfIn = $_POST['tlf'];

			$sql = "INSERT INTO bruker (brukernavn, epost, fnavn, enavn, passord, brukertype, telefonnummer)";
			$sql .= " VALUES (:bn, :ep, :fn, :en, :pw, :bt, :tl)";
			$stmt = $db->prepare($sql);
			$stmt->bindParam(":bn", $brukernavn);
			$stmt->bindParam(':ep', $epostadresse);
			$stmt->bindParam(':fn', $fnavn);
			$stmt->bindParam(':en', $enavn);
			$stmt->bindParam(':pw', $passord);
			$stmt->bindParam(':bt', $brukertype);
			$stmt->bindParam(':tl', $tlfIn);

			$stmt->execute();
			if($stmt->rowCount()){
				$_SESSION['bruker'] = $brukernavn;
				$_SESSION['brukertype'] = $brukertype;
				$_SESSION['fornavn'] = $fnavn;

				$sql2 = "SELECT idbruker FROM bruker WHERE brukernavn =:br";
				$stmt2 = $db->prepare($sql2);
				$stmt2->bindParam(':br', $brukernavn);
				$stmt2->execute();
				
				$id = "";
				if($stmt2->rowCount()) {
					while($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
						$id = $row['idbruker'];
					}
				}
				$_SESSION['idbruker'] = $id;
				$fs = 1;

				$sqlIn = "INSERT INTO preferanse (bruker,visfnavn, visenavn, visepost, vistelefonnummer,visinteresser,visbeskrivelse) VALUES(:bi,:fn,:en,:ep,:tl,:rl,:bg)";
				$stmt3 = $db->prepare($sqlIn);
				$stmt3->bindParam(':bi', $_SESSION['idbruker']);
				$stmt3->bindParam(':fn', $fs);
				$stmt3->bindParam(':en', $fs);
				$stmt3->bindParam(':ep', $fs);
				$stmt3->bindParam(':tl', $fs);
				$stmt3->bindParam(':rl', $fs);
				$stmt3->bindParam(':bg', $fs);
				$stmt3->execute();

				if($stmt3->rowCount()) {
					header('Location: ../default.php');
				}

				

			}elseif(!$stmt->execute()) {
				$_SESSION['tilbakemelding'] = 5;
				header('Location: ../registrer.php');
				// Skal utvides med sjekk om brukernavn eller email finnes fra før
			}

		} else {
			$_SESSION['tilbakemelding'] = 4;
			header('Location: ../registrer.php');
		}

	} else {
		header("Location: ../default.php");
	}
?>

<!-- Skrevet og kontrollert i fellesskap av Gruppe 6 -->