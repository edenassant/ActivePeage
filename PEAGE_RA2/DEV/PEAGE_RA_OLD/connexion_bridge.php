<?php


// Connexion pour une base nommée  en local

$base = "sa";
$pass = "bridge";
$server = "bridge" ;
$database = "barcodes";


// Connexion à MSSQL


$dsn = "Driver={ODBC Driver 18 for SQL Server};Server=$server;Database=$database;TrustServerCertificate=Yes;";
$connexion_bridge = odbc_connect($dsn, $base, $pass);

if (!$connexion_bridge) {
    die('Impossible de se connecter à la base Barcodes de rungis accueil ! Merci de prévenir le service informatique.');
}


/*$dsn = "Driver={ODBC Driver 18 for SQL Server};Server=$server;Database=$database;";
$connexion_bridge = odbc_connect($dsn, $base, $pass);
//$connexion_bridge  = odbc_connect($server, $database, $pass);
//$connexion_bridge  = odbc_connect("Driver={SQL Server};Server=$server;Database=$database;", $base, $pass);

if (!$connexion_bridge ) {
    die('Impossible de se connecter à la base Barcodes de rungis accueil! merci de prévenir le service informatique');}
    */

$retour = "Retour à la page d'accueil";
?> 

 


