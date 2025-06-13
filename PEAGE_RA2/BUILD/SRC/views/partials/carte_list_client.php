

<table border="1">
  <caption>Cartes du client</caption>
  <thead>
    <tr>
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
      <td><?= htmlspecialchars($c['ca_code']) ?></td>
      <td><?= htmlspecialchars($c['tcarte_lib']) ?></td>
      <td><?= htmlspecialchars($c['ca_immatriculation']) ?></td>
      <td><?= $c['ca_immat_peage_autorise'] ? '✅' : '❌' ?></td>
      <td><?= htmlspecialchars($c['ca_champ_3']) ?></td>
      <td>
        <?php
        if ($c['ca_valid'] == 1) {
            echo '<span style="color: green; font-weight: bold;">✅</span>';
        } elseif ($c['ca_statut'] === 'A_ACTIVER') {
            echo '<span style="color: orange; font-weight: bold;">⚠️ PROVISOIRE - Ne pas autoriser le passage</span>';
        } else {
            echo '<span style="color: red; font-weight: bold;">❌</span>';
        }
        ?>
      </td>
      <td><?= htmlspecialchars($c['rci_lib']) ?></td>
      <td><?= $c['ca_ln'] ? '✅' : '❌' ?></td>
      <td><?= htmlspecialchars($c['rln_lib']) ?></td>
      <td><?= htmlspecialchars($c['clas_lib']) ?></td>
      <td><button onclick="loadCarteDetail('<?= $c['c_code'] ?>','<?= $c['ca_code'] ?>')">Détails</button></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php /*
<footer style="text-align: -moz-center; font-size: 12px; color: #999;">
    &copy; Eden Assant
</footer>
*/ ?>