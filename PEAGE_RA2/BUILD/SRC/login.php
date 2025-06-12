<?php
session_start();
require 'config.php';

ldap_set_option(NULL, LDAP_OPT_DEBUG_LEVEL, 7);
ldap_set_option(NULL, LDAP_OPT_X_TLS_REQUIRE_CERT, LDAP_OPT_X_TLS_NEVER);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $ldapConn = ldap_connect($ldap_host);
    
    // Configuration sécurisée LDAP
    ldap_set_option($ldapConn, LDAP_OPT_PROTOCOL_VERSION, 3);


    try {
        // Étape 1 : Bind initial avec le DN complet de l'utilisateur
        $userDn = $username."@min.fr";
    
        if ($ldapConn) { 
            if (!@ldap_bind($ldapConn, $userDn, $password)) {
                throw new Exception("Identifiants incorrects");
            }
        } else {
            throw new Exception("Impossible de se connecter au serveur LDAP - Contactez le support informatique");
        }

        // Étape 2 : Vérification de l'appartenance au groupe
        $groupFilter = "(member=CN=".$username.",OU=utilisateurs,OU=Rungis,DC=min,DC=fr)";
        $searchResult = ldap_search(
            $ldapConn, 
            $ldap_group_user_dn, 
            $groupFilter, 
            ['dn']
        );
        $entries = ldap_get_entries($ldapConn, $searchResult);

        if ($entries['count'] == 0) {
            throw new Exception("Vous n'appartenez pas au groupe autorisé");
        }

        // Connexion réussie
        $_SESSION['username'] = $username;
        $_SESSION['group'] = $ldap_group_user_dn;
        
        // Log de connexion réussie
        error_log("Connexion réussie pour {$username} le " . date('Y-m-d H:i:s'));
        
        header('Location: index.php');
        exit();

    } catch (Exception $e) {
        $error = $e->getMessage();
        
        // Log des tentatives échouées
        error_log("Échec de connexion pour {$username} : " . $e->getMessage() . " le " . date('Y-m-d H:i:s'));
    } finally {
        ldap_close($ldapConn);
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Connexion - Péage Rungis Acheteurs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
            background-color: #ffffff;
        }
        .logo {
            max-width: 150px;
            margin-bottom: 10px;
        }
        h1 {
            margin: 10px 0;
            font-size: 24px;
            color: #333;
        }
        form {
            background-color: #f4f4f4;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        input {
            display: block;
            margin: 10px auto;
            padding: 10px;
            width: 250px;
        }
        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
        }
        .support-link {
            margin-top: 15px;
            font-size: 14px;
        }
        .support-link a {
            color: #007bff;
            text-decoration: none;
        }
        .support-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <img src="logo.png" alt="Logo Rungis" class="logo">
    <h1>Application Péage Rungis Acheteurs</h1>

    <form method="POST">
        <h2>Connexion</h2>
        <?php if ($error): ?>
            <p style="color: red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <input type="text" name="username" placeholder="Nom d'utilisateur" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <button type="submit">Se connecter</button>

        <div class="support-link">
            <p>Besoin d’aide ? <a href="https://helpdesk.min.fr/sso" target="_blank">Contactez le support.</a></p>
        </div>
    </form>
</body>
</html>