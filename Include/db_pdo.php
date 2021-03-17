<?php
// Hentet fra forelesning

class mysqlPDO extends PDO {
  public function __construct() {
  $drv = 'mysql';
  $hst = 'REDACTED'; // eller 's120.hbv.no'
  $usr = 'usr_klima';
  $pwd = 'REDACTED';
  $sch = 'klima';
  $dsn = $drv . ':host=' . $hst . ';dbname=' . $sch;
  parent::__construct($dsn,$usr,$pwd);
  }
}

$db = new mysqlPDO();
$salt = "REDACTED";


// Skrevet og kontrollert i fellesskap av Gruppe 6 
?>
