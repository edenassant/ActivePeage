<?php


error_reporting(E_ALL);
ini_set("display_errors", 1);
var_dump($_POST); // pour voir ce que JS envoie vraiment

require_once '../config.php';
require_once '../classes/Carte.php';
require_once '../classes/Client.php';
require_once '../classes/Ticket.php';



$code_client = $_POST['code_client'] ?? null;

$activite  = $_POST['activite'] ?? null;



try {
    $db_cristal = new PDO($db_cristal_dsn, $db_cristal_user, $db_cristal_password);
    $db_cristal->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $db_bridge = new PDO($db_bridge_dsn, $db_bridge_user, $db_bridge_password);
    $db_bridge->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $carte = new Carte($db_cristal);
    $client = new Client($db_cristal);
    $ticket = new Ticket($db_bridge);



    $client_info = $client->getClientInfo($code_client);
    $client_pass_express = $ticket->searchPassExpressByClient($code_client);
    $cartes= $carte->searchCartesByClient($code_client,$activite);


//    echo '<pre>';
//    var_dump($client_info);
//    var_dump($client_pass_express);
//    var_dump($cartes);
//    echo '</pre>';


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

// Le reste de ton code ici...


} catch (PDOException $e) {
    echo "<p>Erreur de connexion : " . $e->getMessage() . "</p>";
}





