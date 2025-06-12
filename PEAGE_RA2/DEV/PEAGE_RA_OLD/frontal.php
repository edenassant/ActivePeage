<html>

<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet" type="text/css">
    <style>
        body {
            zoom: 70%; /* Modifier la valeur pour ajuster le niveau de zoom */
        }
    </style>

<link href=style.css rel=stylesheet type=text/css>
</head>
<?php
require("verifylogin.php");
?>

<?php

//session_start();

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
//$action = isset($_POST['action']) ? $_POST['action'] : '';
$nom = isset($_REQUEST['nom']) ? $_REQUEST['nom'] : '';
$c_code = isset($_POST['c_code']) ? $_POST['c_code'] : '';
$ca_code = isset($_POST['ca_code']) ? $_POST['ca_code'] : '';
$libre = isset($_POST['libre']) ? $_POST['libre'] : '';
$login_code = isset($_POST['login_code']) ? $_POST['login_code'] : '';
$plaque = isset($_POST['plaque']) ? $_POST['plaque'] : '';

//$login = isset($_REQUEST['login']) ? $_REQUEST['login'] : '';
$login=$_SESSION['login'];
//$login = isset($_SESSION['login']) ? $_SESSION['login'] : 'utilisateur inconnu';*/



switch($action)
 {
	// recherche à partir du code client	

	case "codeclient";

	    require ("connexion.php");

	    $requete = "SELECT * from client a where C_CODE = $c_code ";
	    $resultat = odbc_exec($connexion,$requete);
		$codeclient = odbc_result($resultat,"C_CODE");
		
	    if ( $codeclient < 1 ) 
	    {
		    echo "<table width = 100% border=0>";
			    echo "<tr>
				    <td align=center><font face=verdana size=3>Le code client saisi ne correspond à aucun client de Rungis Accueil </font></td><br>
			    </tr>";
			echo"</table>";
	    }
	    else						
	    {
            require("affichage_detail_client.php");
		    require("affichage_liste_cartes.php");
	    }	
		
		
	break;

    
    
    // recherche à partir du code client et du numero de la carte	
    case "numclient_carte";
    
        require ("connexion.php");

	    // existence du client
	    $requete5 = "SELECT C_CODE FROM carte where C_CODE = '$c_code' ";
	    $resultat5 = odbc_exec($connexion,$requete5);
	    $codeclient = odbc_result($resultat5,"C_CODE");	
	
	
        // existence de la carte
	    $requete4 = "SELECT * FROM carte where C_CODE = '$c_code' and ca_code = '$ca_code'";
	    $resultat4 = odbc_exec($connexion,$requete4);

if ($resultat4) {
	$codecarte = odbc_result($resultat4,"C_CODE");	
} else {
	echo "<table width = 100% border=0>";
	echo "<tr>
		<td align=center><font face=verdana size=3>Aucun résultat ne correspends à votre recherche</font></td><br>
	</tr>";
echo"</table>";
}
	
	    if ( $codeclient < 1 ) 
	    {
			require("affichage_detail_client.php");
	    }
	    else						
	    {
		    if ( $codecarte < 1 ) 
		    {
			    require("affichage_detail_client.php");
		
			    require("affichage_liste_cartes.php");
	
			    // nombre de carte par client
			    //$requete6 = "select max(ca_code) as qte FROM carte where C_CODE = $c_code ";
			    //$resultat6 = odbc_exec($connexion,$requete6);
			    //$maxcarte = odbc_result($resultat6,"qte") + 1 ;			
			    //echo "<table width = 100% border=0>";
			    //echo "<tr>
			    //	<td align=center><font face=verdana size=3>Ce numéro de carte n'existe pas pour ce client. Veuillez saisir un numéro de carte inférieur à $maxcarte </font></td><br>
			    //</tr>";
			    //echo"</table>";
		    }
		    else						
		    {		
                require("affichage_detail_client.php");
		        require("affichage_detail_carte.php");
		   }
	    }		
	break;



    case "nomclient";

	    require ("connexion.php");
	
	    if ( strlen($nom) < 3 ) 
	    {
            echo "<table width = 100% border=0>";
			    echo "<tr>
				    <td align=center><font face=verdana size=3>Votre recherche doit contenir au moins 3 caractères</font></td><br>
			    </tr>";
		    echo"</table>";
	    }
	    else						
	    {
		    // affichage des clients dont la raison sociale contient la saisi 
		    require("affichage_liste_clients.php");
        }
    break;

    // rechercherche à partie des info de la cartes	
    case "nomlibre";

	    require ("connexion.php");

	    if ( strlen($libre) < 3 ) 
	    {
			echo "<table width = 100% border=0>";
			    echo "<tr>
				    <td align=center><font face=verdana size=3>Votre recherche doit contenir au moins 3 caractères</font></td><br>
			    </tr>";
			echo"</table>";
	    }
	    else						
	    {
		    // affichage des cartes dont la recherche  contient la saisi 	
		    require("affichage_liste_cartes_recherche_info_carte.php");
	    }
			
	break;
	

    // rechercherche à partie l'immat de la cartes	
    case "immatriculation";

	    require ("connexion.php");

	    if ( strlen($plaque) < 4 ) 
	    {
			echo "<table width = 100% border=0>";
			echo "<tr>
				<td align=center><font face=verdana size=3>Votre recherche doit contenir au moins 3 caractères test $plaque</font></td><br>
			</tr>";
			echo"</table>";
	    }
	    else						
	    {
		    // affichage des clients dont la raison sociale contient la saisi 	
		    require("affichage_liste_cartes_recherche_immat.php");
        }
		
	break;

	
	case  "details":
		require("connexion.php");

		require("affichage_detail_carte.php");
		
	break;

	case "liste":
		require("connexion.php");
		require("affichage_liste_cartes.php");
		break;
             

    default:

    echo "<center><table border=1>";

echo"<td width = 250>";
   echo "<center><table>";
   
    echo "<form method=post action=frontal.php>";
		    echo "<input type=hidden name=login_code value=$login_code>";

			echo "
			<tr>
				<td  align=center><image src=logo.jpg><br></td>
			</tr> 	
			<tr>
    				<br><td  align=center>utilisateur : <font face=verdana size=4>$login</font></td> 
		
  			</tr>
  			<tr>
				  <td align=center>
				   	<br><br><input type=submit value='Effacer les données'>
				  </td>
			</tr>";
		   echo "</form></table></center>";
echo"</td>";

// recherche a partir du numéro de client et du numéro de carte


echo"<td width = 400>";
   echo "<center><table>";

   echo "<tr><td colspan=2 align=center><font face=verdana color= red size=3><b>Recherche à partir du code client <br>et du numéro de carte</b><br><br></font></td>";
   
   echo "<form method=post action=frontal.php target = RESULT>";
		   echo "<input type=hidden name=action value=numclient_carte>";
		   echo "<input type=hidden name=login_code value=$login_code>";

			
			echo "<tr>
				<td width = 50% ><font face=verdana size=2><b>code client : </b></font></td>
				<td width = 50%><input type=text name=c_code maxlength=6 size=20></td>
			</tr>";

   			echo "<tr>
				<td width = 50% ><font face=verdana size=2><b>numéro de     la carte:</b></font></td>
				<td width = 50%><input type=text name=ca_code maxlength=5 size=20></td>
			</tr>";

			echo "<tr>
				  <td colspan=2 align=center>
				   <br><br><input type=submit value=valider>
				  </td>
				</tr>";
		   echo "</form></table></center>";
echo"</td>";

// recherche a partir du numéro de client 



//recherche sur une partie de la raison sociale ou de l'enseigne

echo"<td width = 400>";
   echo "<center><table>";
   echo "<tr><td colspan=2 align=center><font face=verdana color= red size=3><b>Recherche à partir de la raison sociale ou de l'enseigne ou du nom du correspondant</b><br><br><br></font></td>";
   
    echo "<form method=post action=frontal.php target = RESULT>";
		   echo "<input type=hidden name=action value=nomclient>";
		   echo "<input type=hidden name=login_code value=$login_code>";

			require ("connexion.php");
			
			echo "<tr>
				<td width = 40% ><font face=verdana size=2><b>Raison sociale : </b></font></td>
				<td width = 60% ><input type=text name=nom maxlength=30 size=30></td>
			</tr>";
   	
			echo "<tr>
				  <td colspan=2 align=center>
				   <br><input type=submit value=valider>
				  </td>
				</tr>";
		   echo "</form></table></center>";
echo"</td>";

// recherche à partir des informations de la carte ( libre 1 , libre 2 , libre 3 )
echo"<td width = 400>";
   echo "<center><table>";
   echo "<tr><td colspan=2 align=center><font face=verdana color= red size=3><b>Recherche à partir des informations de la carte ( libre 1 , libre 2 , libre 3 )</b><br><br><br></font></td>";
   
    echo "<form method=post action=frontal.php target = RESULT>";
		   echo "<input type=hidden name=action value=nomlibre>";
		   echo "<input type=hidden name=login_code value=$login_code>";

			require ("connexion.php");
			
			echo "<tr>
				<td width = 10% ></td>
				<td width = 80% ><input type=text name=libre maxlength=25 size=40></td>
			</tr>";
   	
			echo "<tr>
				  <td colspan=2 align=center>
				   <br><br><input type=submit value=valider>
				  </td>
				</tr>";
		   echo "</form></table></center>";
	echo"</td>";



// recherche à partir de l'immatriculation de la carte
echo"<td width = 400>";
   echo "<center><table>";
   echo "<tr><td colspan=2 align=center><font face=verdana color= red size=3><b>Recherche à partir de l'immatriculation de la carte</b><br><br><br></font></td>";
   
    echo "<form method=post action=frontal.php target = RESULT>";
		   echo "<input type=hidden name=action value=immatriculation>";
		   echo "<input type=hidden name=login_code value=$login_code>";

			require ("connexion.php");
			
			echo "<tr>
				<td width = 50% ><center><font face=verdana size=2><b>Immatriculation : </b></font></td>
				<td width = 50% ><input type=text name=plaque maxlength=25 size=20></td>
			</tr>";
   	
			echo "<tr>
				  <td colspan=2 align=center>
				   <br><br><input type=submit value=valider>
				  </td>
				</tr>";
		   echo "</form></table></center>";
	echo"</td>";

    break;
}


?>
</html>