<?php
    include('../Include/db_pdo.php');
    session_start();
    include('../Include/sjekkLovAdmin.php');
    $htmlfil =fopen("../Regel/regel.html", "w");
    $tekst = '<!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">    
        <link rel="stylesheet" href="../CSS filer/backend.css">
        <link rel="stylesheet" href="CSS filer/FontAwesome/fontawesome.css">
        <link href="https://fonts.googleapis.com/css?family=Almarai|Zhi+Mang+Xing&display=swap" rel="stylesheet">
        <title>Hovedmeny</title>
    </head>
    <body>
        <header>
            <a href="../default.php"><h1 style="text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;">Greentalk</h1></a>
            <p style="text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;">"Et samfunn for miljøforkjempere"</p>
        </header>
        <nav>
            <section class="topnav" id="myTopnav" >
                <a href="../default.php#aktuelt" tabindex="1" id="først">Aktuelt</a>
                <a href="../default.php#arrangementer" tabindex="2">Arrangementer</a>
                <a href="../default.php#omoss" tabindex="3">Om oss</a>
            </section>
        </nav>
        </body>
        <h1>Regler:</h1>
        <section id="regler">';
    
    fwrite($htmlfil,$tekst);

    // Finner alle regler
    $sql = "SELECT regeltekst FROM regel";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    
    if($stmt->rowCount()){
        $antall=1;
        while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
            $regel ="<p>".$antall.". " . $row['regeltekst'] . "</p>";
            fwrite($htmlfil,$regel);
            $antall++;
        }
    }
    $tekst = "    </section>
    </html>";
    fwrite($htmlfil,$tekst);

    fclose($htmlfil);

    header('Location:../Regel/regel.html');


?>