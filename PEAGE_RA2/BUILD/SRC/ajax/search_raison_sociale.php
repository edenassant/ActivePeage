<?php
require_once '../config.php';
require_once '../classes/Client.php';

$raison = $_POST['raison_sociale'] ?? null;

if (!$raison) {
    echo "<p>Veuillez renseigner une raison sociale.</p>";
    exit;
}

try {
    $db_cristal = new PDO($db_cristal_dsn, $db_cristal_user, $db_cristal_password);
    $db_cristal->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $client = new Client($db_cristal);
    $clients = $client->searchClientsByRaisonSociale($raison);

    include '../views/partials/client_list.php';

} catch (PDOException $e) {
    echo "<p>Erreur : " . $e->getMessage() . "</p>";
}