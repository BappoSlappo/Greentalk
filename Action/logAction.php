<?php
	// LISTE
	// Sjekk om antall logginn er 5 og hvis så sjekk cooldownen på tiden
	// Hvis ikke legg til +1 på antalllogginn
	// Gi feilmelding

	session_start();
	include('../Include/db_pdo.php');

	// Hvis knappen er trykket
	if(isset($_POST['knapp']) and $_POST['knapp'] == 'sjekk') {

		// Henter inn passord/brukernavn fra form
		$pw = $_POST['passord'];
		$bruker = $_POST['bruker'];

		// Salter/hasher passordet
		$pw = sha1($salt.$pw);

		// Sjekker om brukeren er "slettet"
		$sql = "SELECT * FROM bruker, brukertype WHERE bruker.brukernavn = :br AND bruker.brukertype = 4";
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':br', $bruker);
		$stmt->execute();

		if($stmt->rowCount()){
			// bruker er slettet
			echo "Slettet";
			$_SESSION['tilbakemelding'] = 5;
			header('Location: ../logginn.php');
		} else {

			// Finner antall prøvde loggins
			$sql = "SELECT feillogginnteller FROM bruker WHERE brukernavn = :br";

			$stmt = $db->prepare($sql);
			$stmt->bindParam(':br', $bruker);
			$stmt->execute();

			// Hvis bruker finnes
			if($stmt->rowCount()){
				echo "Bruker finnes <br>";
				$antall;
				while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
					$antall = $row['feillogginnteller'];
				}

				// Sjekk om antall prøvd er 5
				if($antall >= 5) {
					$no;
					$lovlig;

					// Sjekk om cd på utestenging er over
					$sqlTid = "SELECT feillogginnsiste + INTERVAL 5 MINUTE FROM bruker WHERE brukernavn =:br";
					$stmtTid = $db->prepare($sqlTid);
					$stmtTid->bindParam(':br', $bruker);
					$stmtTid->execute();

					// tiden nå + 5 min
					$sqlNo = "SELECT NOW()";
					$stmtNo = $db->prepare($sqlNo);
					$stmtNo->execute();

					if($stmtTid->execute()){
						while($radTid = $stmtTid->fetch(PDO::FETCH_ASSOC)){
							$lovlig = $radTid['feillogginnsiste + INTERVAL 5 MINUTE'];
						}
					}

					if($stmtNo->execute()){
						while($radNo = $stmtNo->fetch(PDO::FETCH_ASSOC)){
							$no = $radNo['NOW()'];
						}
					}

					echo "Tiden no:  ".$no;
					echo "<br>";
					echo "Lovlig: ".$lovlig.'<br>';

					// Hvis tids cd er over
					// Legge til tid
					if($no>=$lovlig){
						echo "Finnes rad";
						// Sett antall til 0
						// La logge inn
						$sqlUp = "UPDATE bruker SET feillogginnteller=". 0 . " WHERE brukernavn =:br";
						$stmtUp = $db->prepare($sqlUp);
						$stmtUp->bindParam(':br', $bruker);
						$stmtUp->execute();
						echo "Antall: " . 0;					

						// Hent ut bruker data, logg inn
						$sqlLog = "SELECT brukertype, idbruker, fnavn FROM bruker WHERE brukernavn =:br AND passord = :pw";
						$stmtLog = $db->prepare($sqlLog);
						$stmtLog->bindParam(':br', $bruker);
						$stmtLog->bindParam(':pw', $pw);

						$stmtLog->execute();
						echo $stmtLog->rowCount();
						// Sjekker om passordet/brukernavn er riktig
						if($stmtLog->rowCount()){

							while($rad = $stmtLog->fetch(PDO::FETCH_ASSOC)){
								$_SESSION['bruker'] = $bruker;
								$_SESSION['brukertype'] = $rad['brukertype'];
								$_SESSION['tilbakemelding'] = 0;
								$_SESSION['idbruker'] = $rad['idbruker'];
								$_SESSION['fornavn'] = $rad['fnavn'];

							}
							header('Location: ../default.php');


						}
					} else {
						// Hvis cd ikke er over
						$_SESSION['tilbakemelding'] = 1;
						header('Location: ../loggInn.php');
						echo "Forsøk igjen om 5 min <br>";
					}
				// Bruker har under 5 forsøk
				} else {
					$sqlLog = "SELECT brukertype, idbruker, fnavn FROM bruker WHERE brukernavn =:br AND passord = :pw";
					$stmtLog = $db->prepare($sqlLog);
					$stmtLog->bindParam(':br', $bruker);
					$stmtLog->bindParam(':pw', $pw);

					$stmtLog->execute();

					// Logg inn
					if($stmtLog->rowCount()) {
						while($rad = $stmtLog->fetch(PDO::FETCH_ASSOC)){
							$_SESSION['bruker'] = $bruker;
							$_SESSION['brukertype'] = $rad['brukertype'];
							$_SESSION['tilbakemelding'] = 0;
							$_SESSION['idbruker'] = $rad['idbruker'];
							$_SESSION['fornavn'] = $rad['fnavn'];

						}
						$sqlUp = "UPDATE bruker SET feillogginnteller=0 WHERE brukernavn =:br";
						$stmtUp = $db->prepare($sqlUp);
						$stmtUp->bindParam(':br', $bruker);
						$stmtUp->execute();
						header('Location: ../default.php');

					// Sett antall++
					} else {
						$antall++;
						$sqlUp = "UPDATE bruker SET feillogginnteller=". $antall . ", feillogginnsiste= NOW() WHERE brukernavn =:br";
						$stmtUp = $db->prepare($sqlUp);
						$stmtUp->bindParam(':br', $bruker);
						$stmtUp->execute();
						echo "Antall: " . $antall++;
						$_SESSION['tilbakemelding'] = 2;
						header('Location: ../logginn.php');

					}

				}

			} else {
				// Hvis bruker ikke finnes
				$_SESSION['tilbakemelding'] = 2;
				header('Location: ../logginn.php');
			}
		}
	}else {
		header("Location: ../default.php");
	}



?>
    <?php
		include("Include/tilbake.php");
		// Skrevet og kontrollert i fellesskap av Gruppe 6 
    ?>