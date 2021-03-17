<?php
    session_start();
    unset($_SESSION['brukertype']);  
    session_destroy();
    header("Location: ../default.php"); 
    // Skrevet og kontrollert i fellesskap av Gruppe 6 
?>