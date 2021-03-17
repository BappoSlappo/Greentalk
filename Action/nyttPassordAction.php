<?php
	include("../Include/db_pdo.php");
	session_start();
	include('../Include/sjekkLov1.php');

	if(isset($_POST['knapp']) and $_POST['knapp'] = 'sjekk') {
		$passord = $_POST['passord'];
		$passord2 = $_POST['passord2'];

		if($passord == $passord2) {
			$boomerPassord = sha1($salt.$_POST['boomerPass']);
			$passord = sha1($salt.$passord);

			$dbpas = "";

			$sql = "SELECT passord FROM bruker WHERE passord=:pw AND brukernavn =:br";

			$stmt = $db->prepare($sql);
			$stmt->bindParam(':br', $_SESSION['bruker']);
			$stmt->bindParam(':pw', $boomerPassord);

			$stmt->execute();

			if($stmt->execute()){
				echo $stmt->rowCount() . '<br>';
				while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$dbpas = $row['passord'];
				}
				echo "Hentet ut passordet";
			} else{
				echo "Feil passord sjekk";
			}

			echo '<br> Db pass:    '.$dbpas;
			echo '<br> Boomerpass: ' .$boomerPassord;
			if($dbpas == $boomerPassord){

				$sql2 = 'UPDATE bruker SET passord =:pw WHERE brukernavn ="' . $_SESSION['bruker'] . '"';;
				$stmt2 = $db->prepare($sql2);
				$stmt2->bindParam(':pw', $passord);

				echo "<br>";
				$stmt2->execute();
				if($stmt2->execute()){
					echo "Endret";
					$_SESSION['passReset'] = 1;
				} else {
					echo "Funker ikke";
				}

				header('Location: ../nyttPassord.php');
			} else {
				$_SESSION['tilbakemelding'] = 4;
				header('Location: ../nyttPassord.php');
			}

		} else {
			$_SESSION['tilbakemelding'] = 6;
			header('Location: ../nyttPassord.php');	
		}
	} else {
		header("Location: ../default.php");
	}

?>
	<?php
        include("../Include/tilbake.php");
    ?>
<!-- Skrevet og kontrollert i fellesskap av Gruppe 6 -->