
<?php

//echo "DEBUG: code client = " . htmlspecialchars($_POST['code_client'] ?? 'rien') . ", carte = " . htmlspecialchars($_POST['numero_carte'] ?? 'rien') . "<br>";

//// Affichage des erreurs
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

//if (empty($carte_detail) || !is_array($carte_detail)) {
//    echo "Erreur : aucune donnée carte disponible.";
////     echo "<pre>";
////     var_dump($carte_detail);
////     echo "</pre>";
//    exit;
//}

$firstCarte = reset($carte_detail);

//// Vérifie si $firstCarte est un tableau valide
//if (!is_array($firstCarte)) {
//    echo "Erreur : première carte invalide.";
//    exit;
//}



?>

<h2>Détail de la carte N°<?= htmlspecialchars($firstCarte['ca_code'] ?? '') ?></h2>
<br>
<div class="table-row">
    <!-- Informations de la carte -->
    <table border="1">
        <caption>Informations de la carte</caption>
        <thead>
        <tr>
            <th>Numéro</th>
            <th>Type</th>
            <th>Nombre d'entrées</th>
            <th>Date de fin</th>
            <th>Immatriculation</th>
            <th>Lecture plaque autorisée</th>
            <th>Libre1</th>
            <th>Libre2</th>
            <th>Libre3</th>
            <th>Classe</th>
            <th>Active</th>
            <th>Statut</th>
            <th>Liste noire</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($carte_detail)): ?>
        <?php foreach ($carte_detail as $c1): ?>
            <tr>
                <td><?= htmlspecialchars($c1['ca_code']) ?></td>
                <td><?= htmlspecialchars($c1['tcarte_lib'] ?? '') ?></td>
                <td><?= htmlspecialchars($c1['ca_nbre_passage'] >= 999 ? 'infini' : $c1['ca_nbre_passage']) ?></td>
                <td><?= $c1['ca_date_valid'] ? '✅' : '❌'  ?></td>
                <td><?= htmlspecialchars($c1['ca_immatriculation']?? '') ?></td>
                <td><?= isset($c1['ca_immat_peage_autorise']) && $c1['ca_immat_peage_autorise'] ? '✅' : '❌' ?></td>
                <td><?= htmlspecialchars($c1['ca_champ_1']) ?></td>
                <td><?= htmlspecialchars($c1['ca_champ_2']) ?></td>
                <td><?= htmlspecialchars($c1['ca_champ_3']) ?></td>
                <td><?= htmlspecialchars($c1['clas_lib']) ?></td>
                <td>
                    <?php
                    if (($firstCarte['ca_valid'] ?? 0) == 1) {
                        echo '<span style="color: green; font-weight: bold;">✅</span>';
                    } elseif ($firstCarte['ca_statut'] === 'A_ACTIVER') {
                        echo '<span style="color: orange; font-weight: bold;">⚠️ PROVISOIRE - Ne pas autoriser le passage</span>';
                    } else {
                        echo '<span style="color: red; font-weight: bold;">❌</span>';
                    }
                    ?>
                </td>
                <td><?= $c1['ca_ln'] ? '✅' : '❌' ?></td>
                <td><?= $c1['ca_ln'] ? '✅' : '❌' ?></td>
            </tr>
        <?php endforeach; ?>
        <?php else: ?>
        <tr>
            <td colspan="13" style="text-align: center;">Aucune carte trouvée</td>
        </tr>
        <?php endif; ?>
        </tbody>

    </table>
    <table border="1">
        <caption>Derniers passages</caption>
        <thead>
        <tr>
            <th>Date</th>
            <th>Heure</th>
            <th>Voie</th>
            <th>Solde</th>
            <th>Autorisation péager</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($passages)): ?>
            <?php foreach ($passages as $p): ?>
                <tr>
                    <td><?= htmlspecialchars($p['date']) ?></td>
                    <td><?= htmlspecialchars($p['heure']) ?></td>
                    <td><?= htmlspecialchars($p['voie_num']) ?></td>
                    <td><?= htmlspecialchars($p['HPC_SOLDE_PTS']) ?></td>
                    <td><?= $p['HPC_SOLDE_PTS'] == 992 ? '✅' : '❌' ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" style="text-align: center;">Aucun passage trouvé</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>


    <table border="1">
        <caption>Nombre d'autorisations de passages par mois</caption>
        <thead>
        <tr>
            <th>Mois</th>
            <th><b>Nombre de<br>passages<br>avec cartes</b></th>
            <th><b>Nombre<br>d'autorisations<br>de passages</b></th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($passagesMois)): ?>
            <?php foreach ($passagesMois as $p1): ?>
                <tr>
                    <td><?= htmlspecialchars($p1['mois_fr'] ?? '') ?></td>
                    <td><?= htmlspecialchars($p1['pass_cartes'] ?? '') ?></td>
                    <td><?= htmlspecialchars($p1['pass_Autorisation']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3" style="text-align: center;">Aucun historique mensuel trouvé</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>

    <?php include 'alertes_sms.php'; ?>

</div>

<?php if (!empty($client_info['c_code'])): ?>

<div style="text-align: center; margin-top: 20px;">
    <button onclick="loadClientDetail('<?= htmlspecialchars($client_info ['c_code']) ?>')"  style="padding: 12px 24px; font-size: 18px;">
        Voir toutes les cartes
    </button>
</div>
<?php endif; ?>
<?php /*
<footer style="text-align: -moz-center; font-size: 12px; color: #999;">
    &copy; Eden Assant
</footer>
*/?>


