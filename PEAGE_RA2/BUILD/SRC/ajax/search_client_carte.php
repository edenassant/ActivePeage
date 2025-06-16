<?php

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
////
////
//////error_reporting(E_ALL);
////ini_set("display_errors", 1);
//var_dump($_POST);
//exit;

require_once '../config.php';
require_once '../classes/Carte.php';
require_once '../classes/Client.php';
require_once '../classes/Ticket.php';



$code_client = $_POST['code_client'] ?? null;

if (empty($code_client)) {
    http_response_code(400); // Mauvaise requête
    echo "Erreur : code client manquant.";
    exit;
}


$activite  = $_POST['activite'] ?? false;



try {
    $db_cristal = new PDO($db_cristal_dsn, $db_cristal_user, $db_cristal_password);
    $db_cristal->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $db_bridge = new PDO($db_bridge_dsn, $db_bridge_user, $db_bridge_password);
    $db_bridge->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $carte = new Carte($db_cristal);
    $client = new Client($db_cristal);
    $ticket = new Ticket($db_bridge);



    $client_info = $client->getClientInfo($code_client);
//    var_dump($client_info);
//    if (!$client_info) {
//        echo "Client non trouvé<br>";
//        exit;
//    }
    $client_pass_express = $ticket->searchPassExpressByClient($code_client);
//    var_dump($client_pass_express);

    $cartes= $carte->searchCartesByClient($code_client,$activite);



//    exit;
//    echo '<pre>';
//    var_dump($client_info);
//    var_dump($client_pass_express);
//    var_dump($cartes);
//    echo '</pre>';
//
//
    include '../views/partials/client_info.php';
    include '../views/partials/carte_list_client.php';

    #$client_info = $client->getClientInfo($code_client, $numero_carte);
    #$cartes = $carte->getCartesByClient($code_client);
    #$alertes = $ticket->getAlertesClient($code_client);
    #$pass_express = $ticket->getPassExpress($code_client);
#
    #include '../views/partials/client_info.php';
    #include '../views/partials/alertes_sms.php';
    #include '../views/partials/carte_list.php';

// Récupération du code client envoyé en POST
    $code_client = $_POST['code_client'] ?? null;

// la valeur reçue puis stopper l'exécution
//    var_dump($code_client);
//    exit;
//    if (empty($cartes)) {
//        echo "<p>Aucune carte trouvée pour ce client.</p>";
//    } else {
//        echo "<p>" . count($cartes) . " carte(s) trouvée(s).</p>";
//    }


} catch (PDOException $e) {
    echo "<p>Erreur de connexion : " . $e->getMessage() . "</p>";
}





