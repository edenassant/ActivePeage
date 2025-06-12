<head>
    <style>
        body {
            zoom: 100%; /*Modifier la valeur pour ajuster le niveau de zoom*/
        }
    </style>
</head>


<?php
session_start();
require ("connexion.php");

if ($connexion) {

	// Initialiser les variables avec la valeur transmise via le formulaire ou une chaîne vide si aucune valeur n'est transmise
	$login = isset($_POST['login']) ? $_POST['login'] : '';
	$password = isset($_POST['password']) ? $_POST['password'] : '';


  $flag=0;
if (!$login)
    	{
   		echo"<BR>";
		echo "<center><font face=verdana size=3><b>Le login ne peut être nul.</b></font></center><br>";
   		$flag=1;
    	}
	
if (!$password)
 	{
    		echo"<BR>";
		echo "<center><font face=verdana size=3><b>Le mot de passe ne peut être nul.</b></font></center><br>";
   		$flag=1;
	}


if ($flag==1)
    {
     echo "<center><script=\"Javascript\"><form><input type=reset value=retour  onClick=\"history.go(-1)\"></form></script></center>";
    }
    else
    {
	
      	
	//echo"$login";
	//Connection parameters
		$host = "ldap://min.fr";
		$user = $_POST["login"]."@min.fr";
		$pass = $_POST["password"];
		$dn = "OU=utilisateurs,DC=min,DC=fr";

	//Connection AD
		if (!empty($_POST["login"]) AND !empty($_POST["password"])) 
		{
			$adConn = ldap_connect($host) or die("La connection a échouée!");
			
			//protocole version et bind
			ldap_set_option($adConn, LDAP_OPT_PROTOCOL_VERSION, 3);
			ldap_set_option($adConn, LDAP_OPT_X_TLS_REQUIRE_CERT, LDAP_OPT_X_TLS_NEVER);

			$bd = @ldap_bind($adConn, $user , $pass);
		
			
			
			// Identification
		
			if ($bd == 1) 
			{
			      
						$login_code = 1;
			
						//On ajoute l'abonné aux variables de session
        
						$_SESSION['login'] = $login; 
						$_SESSION['login_code'] = $login_code; 

						//echo"$_POST['login']";
			
						//echo"$login";

						// echo"$login_code";
			

						require("accueil.php");
					//}
    			} 
			else 
			{
        			echo"<BR>";
				echo "<center><font face=verdana size=3><b>Votre saisie est mauvaise, veuillez recommencer.</b></font></center><br>";
				echo "<center><script=\"Javascript\"><form><input type=reset value=retour  onClick=\"history.go(-1)\"></form></script></center>";
    					
			}

		}	

	}


	$result = odbc_close($connexion);

}
?>