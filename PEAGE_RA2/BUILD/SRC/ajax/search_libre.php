<?php
require_once '../config.php';
require_once '../classes/Carte.php';

$libre = $_POST['libre'] ?? '';
$activite = $_POST['activite'] ?? '';


try {
    $db_cristal = new PDO($db_cristal_dsn, $db_cristal_user, $db_cristal_password);
    $db_cristal->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $carte = new Carte($db_cristal);
    $cartes = $carte->searchCartesByLibres($libre,$activite);

    include '../views/partials/carte_list_immat.php';

} catch (PDOException $e) {
    echo "<p>Erreur : " . $e->getMessage() . "</p>";
}
