


<table border="1">
  <caption>Cartes</caption>
  <thead>
    <tr>
      <th>Numéro client</th>
      <th>Raison Sociale</th>
      <th>Numéro carte</th>
      <th>Type</th>
      <th>Immat</th>
      <th>Lecture plaque</th>
      <th>Libre3</th>
      <th>Active</th>
      <th>Motif inactivité</th>
      <th>Liste noire</th>
      <th>Motif LN</th>
      <th>Classe</th>
      <th>Détails</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($cartes as $c): ?>
    <tr>
      <td><?= htmlspecialchars($c['c_code']) ?></td>
      <td><?= htmlspecialchars($c['c_rs']) ?></td>
      <td><?= htmlspecialchars($c['ca_code']) ?></td>
      <td><?= htmlspecialchars($c['tcarte_lib']) ?></td>
      <td><?= htmlspecialchars($c['ca_immatriculation']) ?></td>
      <td><?= $c['ca_immat_peage_autorise'] ? '✅' : '❌' ?></td>
      <td><?= htmlspecialchars($c['ca_champ_3']) ?></td>


        <td>
            <?php
            if ($c['ca_valid'] == 1) {
                echo '<span style="color: #19b719; font-weight: bold;">✅</span>';
            } elseif ($c['ca_statut'] === 'A_ACTIVER') {
                echo '<span style="color: #e09d2a; font-weight: bold;">⚠️ PROVISOIRE - Ne pas autoriser le passage</span>';
            } else {
                echo '<span style="color: #e10da5; font-weight: bold;">❌</span>';
            }
            ?>
        </td>

      <td><?= htmlspecialchars($c['rci_lib']) ?></td>
      <td><?=htmlspecialchars( $c['ln']) ? '✅' : '❌' ?></td>
      <td><?= htmlspecialchars($c['rln_lib']) ?></td>
      <td><?= htmlspecialchars($c['clas_lib']) ?></td>
        <td>

            <a onclick="loadCarteDetail('<?= $c['c_code'] ?>','<?= $c['ca_code'] ?>')">🔍</a>
        </td>


    </tr>
    <?php endforeach; ?>
  </tbody>
</table>