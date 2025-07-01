<?php




ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'config.php';

require_once __DIR__ . '/classes/User.php';


require_once __DIR__ . '/app/protection.php';

session_start();


$user = new User();
$username = $user->getUsername();


$hash_attendu = 'e4cb48d6315121408622b298129f845469bca3b6cacd1a1c9f6abbee29fa8069';
$hash_actuel = hash_file('sha256', __DIR__ . '/app/protection.php');

if ($hash_actuel !== $hash_attendu) {
    die(" SITE INNACCESSIBLE REESAYER DANS QUELQUE INSTANT ");
}


if (!function_exists('__protectionEden')) {
    die("Erreur critique : composant de sécurité manquant.");
}

$__eden__txt = __protectionEden();

if (strip_tags($__eden__txt) !== '© Eden Assant') {
    die("Erreur  : modification");
}




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
        <label style="display: flex; align-items: center; gap: 8px; font-size:14px">
            Carte active
            <input type="checkbox" name="activite" style="width: 20px; height: 20px">
        </label>
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
        <label style="display: flex; align-items: center; gap: 8px; font-size:14px">
            Carte active
            <input type="checkbox" name="activite" style="width: 20px; height: 20px">
        </label>
      <button type="submit">Rechercher</button>
    </form>

    <form id="form-immat">
      <h2>Recherche par immatriculation</h2>
        <input name="immat" placeholder="Immatriculation">
        <label style="display: flex; align-items: center; gap: 8px; font-size:14px">
            Carte active
            <input type="checkbox" name="activite" style="width: 20px; height: 20px">
        </label>
        <button type="submit">Rechercher</button>
    </form>


      <button onclick="logout()" style="background-color:  #007bff; color: white; font-size: 20px;">
          Se déconnecter
      </button>

      <script>
          function logout() {
              fetch('logout.php', { //fetch est une méthode native pour envoyer des requêtes API tout en gardant un code clair.
                  method: 'POST'
              }).then(() => {
                  window.location.href = 'login.php';
              });
          }
      </script>

  </section>



  <section id="result-zone"></section>

  <script src="js/script.js"></script>




<?php
  echo "<footer id='eden-copyright' style='text-align:center;color:gray;font-size:14px;margin-top:40px;'>$__eden__txt</footer>";
  ?>

</body>
</html>


