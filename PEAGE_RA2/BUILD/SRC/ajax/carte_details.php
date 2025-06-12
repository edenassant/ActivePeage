<?php

global $carte_detail;
require_once '../config.php';
require_once '../classes/Carte.php';
require_once '../classes/Client.php';
require_once '../classes/Ticket.php';



$code_client = $_POST['code_client'] ?? null;
$numero_carte = $_POST['numero_carte'] ?? null;

if (is_null($code_client) && is_null($numero_carte)) {
    echo "<p>Code client et numéro de carte vide.</p>";
    exit;
}


try {
    $db_cristal = new PDO($db_cristal_dsn, $db_cristal_user, $db_cristal_password);
    $db_cristal->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $db_bridge = new PDO($db_bridge_dsn, $db_bridge_user, $db_bridge_password);
    $db_bridge->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $carte = new Carte($db_cristal);
    $client = new Client($db_cristal);
    $ticket = new Ticket($db_bridge);




    echo "<p>Code client reçu : " . htmlspecialchars($code_client) . "</p>";

    $client_info = $client->getClientInfo($code_client);
    $client_pass_express = $ticket->searchPassExpressByClient($code_client);

//    echo "DEBUG: code client = '$code_client', numéro carte = '$numero_carte'<br>";

    $carte_detail = $carte->getCarteDetail($code_client, $numero_carte);
//    var_dump($carte_detail);



//    if (is_string($carte_detail)) {
//        echo "<p>Erreur dans Carte::getCarteDetail : retour inattendu</p>";
//        echo "<pre>";
//        var_dump($carte_detail);
//        echo "</pre>";
//        exit;
//    }

    $historiques = $carte->getHistoriqueCarteDetail($code_client, $numero_carte);
    $alertes = $carte->getSMSCarteDetail($code_client, $numero_carte);
    $passages = $carte->getPassagesCarteDetail($code_client, $numero_carte);
    $passagesMois = $carte->getHistoriqueMoisCarteDetail($code_client, $numero_carte);


    include '../views/partials/client_info.php';
    include '../views/partials/carte_detail.php';

} catch (PDOException $e) {
    echo "<p>Erreur de base de données : " . $e->getMessage() . "</p>";
}