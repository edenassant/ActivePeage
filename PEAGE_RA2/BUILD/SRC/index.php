<?php
require_once 'config.php';

session_start();

#$user = new User();
#$username = $user->getUsername();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Recherche Client/Carte</title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>

  <section id="search-zone">
    <form id="form-client-carte">
      <h2>Recherche par code client + carte</h2>
      <input name="code_client" placeholder="Code client"  >
      <input name="numero_carte" placeholder="Numéro de carte" >
        <input name="activite" placeholder="Activite">

        <button type="submit">Rechercher</button>
    </form>



    <form id="form-raison">
      <h2>Recherche par raison sociale</h2>
      <input name="raison_sociale" placeholder="Raison sociale">
      <button type="submit">Rechercher</button>
    </form>

    <form id="form-libre">
      <h2>Recherche par champs libre</h2>
      <input name="libre" placeholder="Libre">
      <button type="submit">Rechercher</button>
    </form>

    <form id="form-immat">
      <h2>Recherche par immatriculation</h2>
      <input name="immat" placeholder="Immatriculation">
      <button type="submit">Rechercher</button>
    </form>
    
  </section>

  <section id="result-zone"></section>

  <script src="js/script.js"></script>
</body>
</html>


