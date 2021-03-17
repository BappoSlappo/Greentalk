<?php
    include('../include/db_pdo.php');
    session_start();
    include('../Include/sjekkLov1.php');
    
    if(isset($_POST['passord'])){
        $passord = $_POST['passord'];
        $saltpassord = sha1($salt.$passord);
        $sql = "SELECT passord FROM bruker WHERE brukernavn =:br";
        $stmt = $db->prepare($sql);
        $bruker = $_SESSION['bruker'];
        $stmt->bindParam(':br', $bruker);
        
        $stmt->execute();

        if($stmt->rowCount()) {
            $pwd;
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $pwd = $row['passord'];
            }
            if($saltpassord == $pwd) {
                $sql = "UPDATE bruker SET brukertype = '4' WHERE brukernavn =:br";
                $stmt = $db->prepare($sql);
                $bruker = $_SESSION['bruker'];
                $stmt->bindParam(':br', $bruker);

                $stmt->execute();

                if($stmt->execute()) {
                    header('Location: logUt.php');
                } else {
                    header('Location: ../minside.php');
                    // Legg inn melding om feil
                    }
            } else{
                header('Location: ../minside.php');
            }
        } else {header('Location: ../minside.php');}
} else {
    header("Location: ../default.php");
}

?>
    <?php
        include("../Include/tilbake.php");
    ?>