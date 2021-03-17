<!-- Laget av Sanan, Stian og Hannah -->
<?php
	include("Include/db_pdo.php");
	include('Header/header.php');
	include('Include/sjekkLov1Hovedsider.php');
?>
<!DOCTYPE html>
<html>
	<!-- Først kommer raden om bruker informasjon -->
<section class="rad">
	<section class="artikkel2" class="artikkel">
	<h2 class="overskrift">BRUKER INFORMASJON</h2>
		<form action="Action/lastOppBilde.php" method="POST" enctype="multipart/form-data">

		<?php
			$sql = "SELECT hvor FROM bilder, brukerbilde WHERE bilder.idbilder = brukerbilde.bilde AND brukerbilde.bruker = :br";
			$stmt = $db->prepare($sql);
			$stmt->bindParam(':br', $_SESSION['idbruker']);
			$stmt->execute();

			if($stmt->rowCount() > 0) {
				while($rad= $stmt->fetch(PDO::FETCH_ASSOC)) {
					echo '<img src="'. $rad['hvor']. '" alt="Profilbilde" class="SentrertBilde">';
				} 
			} else {
				echo '<img src="https://www.vippng.com/png/detail/363-3631798_profile-placeholder-woman-720-profile-image-placeholder-png.png" alt="Profilbilde" class="SentrertBilde">';
			}

		?>
			
		<div class="fileUpload">
			<input tabindex="7" type="file"  name='bildeInn' required class="upload" />
		</div>
			
		<input tabindex="8" type="submit" class="brukerKnapp" style="position:relative; top:-28px; left:65px; margin-bottom:-20px;" name="submit" value="Last opp bilde">
		</form>
		<form action="skjulInf.php" method="POST">
		<input tabindex="9" type="button" class="brukerKnapp modalKnapp" style="position:relative; " value="Endre personinfo" onclick="visInstillinger()">
		<section class=navn-container>
		<?php
			$sqlInf = "SELECT fnavn, enavn, epost, telefonnummer FROM bruker WHERE brukernavn = :br";
			$stmt2 = $db->prepare($sqlInf);
			$stmt2->bindParam(':br', $_SESSION['bruker']);
			$stmt2->execute();
			
			$fnavn = "";
			$enavn = "";
			$epost = "";
			$tlf = "";
			if($stmt2->rowCount()) {
				while($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
					$fnavn = $row['fnavn'];
					$enavn = $row['enavn'];
					$epost = $row['epost'];
					$tlf =  $row['telefonnummer'];
				}
			}
			

			$visF = 1;
			$visE = 1;
			$visEpost = 1;
			$visTlf = 1;
			$visbeskrivelse = 1;
			$visinteresser = 1;

			$sql = "SELECT visfnavn, visenavn, visepost, vistelefonnummer, visinteresser, visbeskrivelse FROM preferanse WHERE bruker =:br";
			$stmt = $db->prepare($sql);
			$stmt->bindParam(':br', $_SESSION['idbruker']);
			$stmt->execute();

			if($stmt->rowCount()) {
				while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$visF = $row['visfnavn'];
					$visE =$row['visenavn'];
					$visEpost= $row['visepost'];
					$visTlf = $row['vistelefonnummer'];
					$visinteresser = $row['visinteresser'];
					$visbeskrivelse = $row['visbeskrivelse'];

				}
			}
			echo"<p class='navn'>". $fnavn."</p>";
			echo"<p class='navn'>".$enavn."</p>";
			echo"<p class='navn' style='grid-column-start:1; grid-column-end:3'>Email:".$epost."</p>";
			echo"<p class='navn' style='grid-column-start: 1; grid-column-end:3'>Mobil: ".$tlf."</p>";
		?>
		</section>
		</form>
		<!-- Modal endre informasjon -->
	<section class="toRaderModal">
		<section class="modal modalid">
			<section class="modal-innhold">
				<section class="modal-header">
					<span class="close">&times;</span>
					<article class="popup" onclick="popupvindu()">
					<p style="color:white;">?</p>
					<span class="popuptekst" id="popupid">Skjul din informasjon til andre brukere ved å krysse av boksene</span>
					</article>
					<h2 class="modalh2">Endring av informasjon</h2>
				</section>
				<section class="modal-body">
					<form action="Action/endreBrukerInf.php" method="POST">
					<section class="seksjon">
					<section id="visSkjul">
						<section class="modal-container">
						<label for="fnavnVis" class="labelStyling" style="grid-column-start: 1; grid-column-end: 3" type="text">Vis Fornavn:</label>
						<label class="svitsj"><input type="checkbox" name="fnavnVis" value="fnavn" <?php if($visF == 1){echo "checked";}?>><span class="slider round"></label>
						<label for="fnavnVis" class="labelStyling" style="grid-column-start: 4; grid-column-end: 6" type="text">Vis Etternavn:</label>
						<label class="svitsj"><input type="checkbox" name="enavnVis" value="enavn"<?php if($visE == 1){echo "checked";}?>><span class="slider round"></label>
						<label for="fnavnVis" class="labelStyling" style="grid-row-start:2; grid-column-start:1; grid-column-end:3;" type="text">Vis Epost:</label>
						<label class="svitsj"><input type="checkbox" name="epostVis" style="grid-row-start:2;" value="epost"<?php if($visEpost == 1){echo "checked";}?>><span class="slider round"></label>
						<label for="fnavnVis" class="labelStyling" style="grid-row-start:2; grid-column-start: 4; grid-column-end: 6"style=""type="text">Vis Telefonnr:</label>
						<label class="svitsj"><input type="checkbox" name="tlfVis" style="grid-row-start:2;" value="tlf"<?php if($visTlf == 1){echo "checked";}?>><span class="slider round"></label>
						<label for="fnavnVis" class="labelStyling" style="grid-row-start:3;grid-column-start: 1; grid-column-end: 3"type="text">Vis Interesser:</label>
						<label class="svitsj"><input type="checkbox" name="intVis" style="grid-row-start:3;"value="int"<?php if($visinteresser == 1){echo "checked";}?>><span class="slider round"></label>
						<label for="fnavnVis" class="labelStyling" style="grid-row-start:3;grid-column-start: 4; grid-column-end: 6"type="text">Vis Beskrivelse:</label>
						<label class="svitsj"><input type="checkbox" name="besVis" style="grid-row-start:3;" value="bes"<?php if($visbeskrivelse == 1){echo "checked";}?>><span class="slider round"></label>
					</section>
					</section>
					</section>
					<section class="seksjon">
					<section id="navnEndring" class="navn-container">
						<label for="fornavn" class="labelStyling">Fornavn: </label>
						<input type="text" class="inputStyling" name="fornavn" placeholder="Endre fornavn" value="<?php echo $fnavn ?>">
						<label for="etternavn" class="labelStyling"> Etternavn: </label>
						<input type="text" class="inputStyling" name="etternavn" placeholder="Endre etternavn" value="<?php echo $enavn ?>">
						<label for="tlf" class="labelStyling">Telefonnummer: </label>
						<input type="number" class="inputStyling" name="tlf" placeholder="Endre telefonnummer" value="<?php echo $tlf ?>">
				</section>
			</section>
			</section>
					<button type="submit" class="vis-mer" style="margin-top:-10px; margin-bottom:5px;">Oppdater</button>
					</form>
				</section>
				</section>
		</section>

		<button tabindex="10" class="vis-mer modalKnapp" id="modalKnapp">Avregistrer Bruker</button>
		<section id="modalid" class="modal modalid">
			<section class="modal-innhold">
				<section class="modal-header">
					<span class="close">&times;</span>
					<h2>Avregistrering av bruker</h2>
				</section>
				<section class="modal-body">
					<p>Ved å avregistrere brukeren din godtar du at du ikke</p>
					<p>lengre har mulighet til å logge inn igjen</p>
					<p>Vennligst tast inn passordet ditt for å fortsette:</p>
					<form class="form-inline" action="Action/slettBruker.php" method="post">
						<label for="passord">Passord:</label>
						<input type="password" id="pwd" placeholder="Skriv inn passordet ditt" name="passord">
						<button type="submit">Avregistrer</button>
					</form>
				</section>
			</section>
		</section>
	</section>
	<!-- Her kommer rad nr 2 som er brukerens interesser -->
	<section class="artikkel2" class="artikkel">
		<h2  class="overskrift">INTERESSER</h2>
		<section class="container">
			<form action="slettInt.php" method="POST">
		<?php
			// 
			$sql ="SELECT interessenavn FROM brukerinteresse, bruker, interesse WHERE brukerinteresse.bruker = :br AND brukerinteresse.interesse = interesse.idinteresse GROUP BY interessenavn";
			$stmt = $db->prepare($sql);
			$stmt->bindParam(':br', $_SESSION['idbruker']);
			$stmt->execute();

			if($stmt->rowCount()) {
				// Hvis det er rader funnet
				while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
					foreach($row as $ut) {
						$ut2 = '"'.$ut.'"';
						echo "<section class='interesserSlettWrap'>";
						echo "<button class='inters' name='visAndre' value='".$ut."'>".$ut."</button>";
						echo "<button id=".$ut2." name='to' value='".$ut."' class='slettInteressKnapp' style='display:inline'>X</button>";
						echo "</section>";
					}
				}
			}
		?>
		
		</section>
		</form>
		<form action="Action/interesseNy.php" method="POST">
			
			<input tabindex="11" type="text"id="leggtilint" onkeyup="noer(this.value)" name="interesse" placeholder="Søk etter ny interesse">
			<div id="re"></div>
			<button tabindex="12" type="submit" class="vis-mer" id="knapp">Legg til</button>
		</form>
		
	<!-- Her kommer rad nr 3 som er brukerens biografi -->
	</section>
	<section class="artikkel2" class="artikkel">
		<h2  class="overskrift">BIOGRAFI</h2>
		<form action="Action/regBio.php" method="post">
			<?php
				$sql = "SELECT beskrivelse FROM bruker WHERE brukernavn =:br";
				$stmt = $db->prepare($sql);
				$stmt->bindParam(':br', $_SESSION['bruker']);
				$stmt->execute();
				$ut ="";
				if($stmt->execute()) {
					while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
						$ut = $row['beskrivelse'];
					}
				}
			echo '<textarea tabindex="13 "id="utTall" rows="8" cols="40" name="tekst" oninput="endreAntall()" maxlength="1024" placeholder="En beskrivelse av deg selv..." >'.$ut.'</textarea>'
			?>
			<p id="antallTegn">0/1024</p>
			<button tabindex="14" type="submit" class="vis-mer" id="oppdater" style="">Oppdater</button>
		</form>
	</section>
	</section>
</section>
<footer tabIndex="15" onfocus="document.getElementById('først').focus()">
<button id="topBtn" ><i class="fas fa-arrow-up"></i></button>
<?php
include('Include/footer.php');
?>
</footer>
	
</section>
</html>
