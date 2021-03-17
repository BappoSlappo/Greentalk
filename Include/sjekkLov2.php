<?php
	if(isset($_SESSION['brukertype'])) {
        if($_SESSION['brukertype'] == 2 or $_SESSION['brukertype'] ==1){
            
        }else {
            header('Location: ../default.php');
        }
    
	} else {
		header('Location: ../logginn.php');
	}

?>