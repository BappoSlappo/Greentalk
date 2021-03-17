<?php
    session_start(); 
?>
<!-- 
    Deler av topnavigasjon koden tatt fra
    https://www.w3schools.com/howto/howto_js_topnav_responsive.asp
    Hentet den 03.12.2019 
-->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <link rel="stylesheet" href="CSS filer/backend.css">
    <link rel="stylesheet" href="CSS filer/FontAwesome/fontawesome.css">
    <link href="https://fonts.googleapis.com/css?family=Almarai|Zhi+Mang+Xing&display=swap" rel="stylesheet">
    <title>Hovedmeny</title>

</head>
<body>
    <header>
        <a href="default.php"><h1 style="text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;">Greentalk</h1></a>
        <p style="text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;">"Et samfunn for miljøforkjempere"</p>
    </header>
    <nav>
        <section class="topnav" id="myTopnav" >
            <a href="default.php#aktuelt" tabindex="1" id="først">Aktuelt</a>
            <a href="default.php#arrangementer" tabindex="2">Arrangementer</a>
            <a href="default.php#omoss" tabindex="3">Om oss</a>
            <?php
            if(isset($_SESSION['brukertype'])){
                $mail = 0;
                $sql = "SELECT COUNT(lest) AS Ulest FROM melding WHERE lest='0' AND mottaker=:br AND papirkurv='0'";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':br', $_SESSION['idbruker']);
                $stmt->execute();

                if($stmt->rowCount()) {
                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $mail = $row['Ulest'];
                    }
                }
                echo '
                    <section class="dropdown" tabindex="5">
                    <button class="dropbtn" >'. $_SESSION["fornavn"] . '
                    <i class="pil"></i></button>
                    <section class="dropdown-content">
                            <a href="nyttPassord.php">
                            Bytt passord</a>
                            <a href="minside.php">Min side</a>
                            ';if($_SESSION['brukertype']== 1){
                                echo'<a href="administrasjon.php">Administrasjon</a>';
                            };
                echo '
                            <a href="Regel/regel.html">Regler</a>
                    </section>
                    </section>
                    <a href="melding.php" id="utAntallMel" tabindex="4" >Meldinger: '.$mail.'</a>
                    <a href="Action/logUt.php" id="loggut" tabindex="6">Logg ut</a>
                    <a href="javascript:void(0);" class="icon" onclick="myFunction()">
                        <img src="Bilder/ikoner/b.svg" >
                    </a>
                    <section class="dropdown">
                    <form action="slettInt.php" method="POST">
                    <input name="sok" type="text" placeholder="Søk interesse/brukere" tabindex="7">
                    <button name="sokbar" type="submit" class="søkKnapp";>Søk</button>
                    </form>
                    </section>

                    
                ';
            }

            
            else{
                echo '<a href="logginn.php" id="loggut" tabindex="5">Logg inn</a>
                <a href="registrer.php" id="loggut" tabindex="4">Registrer</a>
                <a href="javascript:void(0);" class="icon" onclick="myFunction()">
                    <img src="Bilder/ikoner/b.svg">
                </a>

                ';

            }
            ?>
        </section>
    </nav>
    </body>
</html>

<!-- Skrevet og kontrollert i fellesskap av Gruppe 6 -->