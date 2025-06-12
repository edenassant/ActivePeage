<?php

// Connexion pour une base nommée  en local

$base = "AboRungis";
$pass = "AboRungis";
$dsn = "CRISTAL3" ;
$database = "AboRungis"; // se connecter à la base


// Connexion

//$ODBCConnection = odbc_connect("DRIVER={Devart ODBC Driver for SQL Server};Server=myserver;Database=mydatabase; Port=myport;String Types=Unicode", $user, $password);

//$connexion  = odbc_connect("Driver={SQL Server};Server=$server;Database=$database;", $base, $pass);
$connexion  = odbc_connect($dsn, $base, $pass);

if (!$connexion ) {
    die('Impossible de se connecter à la base de données AboRungis de Rungis Accueil! Merci de prévenir le service informatique.');}

$retour = "Retour à la page d'accueil";
?> 

 



