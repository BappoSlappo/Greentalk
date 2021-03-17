<?php
	if(isset($_SESSION['brukertype'])) {
	} else {
		header('Location: logginn.php');
	}

?>