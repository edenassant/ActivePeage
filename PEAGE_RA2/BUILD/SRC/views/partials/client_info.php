

<div class="table-row">

        <table border="1" cellpadding="5" cellspacing="0">
            <caption>Infos Client</caption>
            <thead>
            <tr>
                <th>Code client</th>
                <th>Raison sociale</th>
                <th>Catégorie</th>
                <th>Activité</th>
                <th>Fin validité</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><?= htmlspecialchars($client_info['c_code'] ?? '') ?></td>
                <td><?= htmlspecialchars($client_info['c_rs'] ?? '') ?></td>
                <td><?= htmlspecialchars($client_info['cat_lib'] ?? '') ?></td>
                <td><?= htmlspecialchars($client_info['a_lib'] ?? '') ?></td>
                <td><?= htmlspecialchars($client_info['c_date_fin_validite'] ?? '') ?></td>
            </tr>
            </tbody>
        </table>

        <br>

        <table>
            <caption>Coordonnées</caption>
            <thead>
            <tr>
                <th>Email</th>
                <th>Portable</th>
                <th>Téléphone</th>
                <th>Adresse facturation</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><?= htmlspecialchars($client_info['C_EMAIL'] ?? '') ?></td>
                <td><?= htmlspecialchars($client_info['C_TEL'] ?? '') ?></td>
                <td><?= htmlspecialchars($client_info['c_alertesms'] ?? '') ?></td>
                <td><?= htmlspecialchars($client_info['AdresseF'] ?? '') ?></td>

            </tr>
            </tbody>
        </table>

        <br>

        <table  class ="table-statut">
            <caption>STATUT</caption>
            <tbody>
            <tr>
                <td>
                    <?php
                    $statut = htmlspecialchars($client_info['c_statut'] ?? 'Inconnu');
                    switch ($statut) {
                        case 'ACTIF':
                            echo '<span style="color: #19b719; font-size: 1.5em;">🟢 Actif</span>';
                            break;
                        case 'PERIME':
                            echo '<span style="color: #e09d2a; font-size: 1.5em;">⚠️ Périmé</span>';
                            break;
                        case 'CLOTURE':
                            echo '<span style="color: #e10da5; font-size: 1.5em;">❌ Clôturé</span>';
                            break;
                            default:
                            echo '<span style="font-size: 1.5em;">' . $statut . '</span>';
                            break;
                    }
                    ?>

                </td>
            </tr>
            </tbody>
        </table>






        <br>
    <?php /*
        <table border="1" cellpadding="5" cellspacing="0">
            <caption>Pass Express valide 2 ans</caption>
            <thead>
            <tr>
                <th>ID du ticket</th>
                <th>Date de début</th>
             <th>Date d'utilisation</th>
            </tr>
            </>
            </thead>
            <tbody>
            <?php if (!empty($client_pass_express)): ?>
                <?php foreach ($client_pass_express as $pass): ?>
                    <tr>
                        <td><?= htmlspecialchars($pass['ID']) ?></td>
                        <td><?= htmlspecialchars($pass['DATE_START_VALID']) ?></td>
                        <td><?= htmlspecialchars($pass['DATE_USED']) ?> <?= htmlspecialchars($pass['DATE_USED_HEURE'] ?? '') ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="3">Aucun pass express valide</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
  */ ?>

</div>

