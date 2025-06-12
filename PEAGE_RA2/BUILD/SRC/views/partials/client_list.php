

<table border="1">
  <caption>Client</caption>
  <thead>
    <tr>
      <th>Numéro client</th>
      <th>Raison Sociale</th>
      <th>Enseigne</th>
      <th>Correspondant</th>
      <th>Catégorie</th>
      <th>Activité</th>
      <th>Date de fin de validité</th>
      <th>Code postal</th>
      <th>Ville</th>
      <th>Statut</th>
      <th>Détails</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($clients as $c1): ?>
    <tr>
      <td><?= htmlspecialchars($c1['c_code']) ?></td>
      <td><?= htmlspecialchars($c1['c_rs']) ?></td>
      <td><?= htmlspecialchars($c1['c_enseigne']) ?></td>
      <td><?= htmlspecialchars($c1['nom_corres']) ?></td>
      <td><?= htmlspecialchars($c1['cat_lib']) ?></td>
      <td><?= htmlspecialchars($c1['a_lib']) ?></td>
      <td><?= htmlspecialchars($c1['c_date_fin_validite']) ?></td>
      <td><?= htmlspecialchars($c1['c_cp_f']) ?></td>
      <td><?= htmlspecialchars($c1['c_commune_f']) ?></td>
      <td>
          <?php
          $statut = htmlspecialchars($c1['c_statut'] ?? 'Inconnu');
          switch ($statut) {
              case 'ACTIF':
                  echo '<span style="color: green; font-size: 1.5em;">🟢 Actif</span>';
                  break;
              case 'PERIME':
                  echo '<span style="color: orange; font-size: 1.5em;">⚠️ Périmé</span>';
                  break;
              case 'CLOTURE':
                  echo '<span style="color: red; font-size: 1.5em;">❌ Clôturé</span>';
                  break;
              default:
                  echo '<span style="font-size: 1.5em;">' . $statut . '</span>';
                  break;
          }
          ?>
</td>
      <td><button onclick="loadClientDetail('<?= $c1['c_code'] ?>')">Détails</button></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>