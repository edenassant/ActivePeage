<html>

<head><link href=style.css rel=stylesheet type=text/css></head>

<?php
require("verifylogin.php");
?>

<?php

require ("connexion.php");


//echo"$login";


if ($connexion) {

echo"<table  border=0 ><center>
  		<tr>
    		<td width=70%></td>
		<td align=left><font face=verdana size=2>Administration : <br><br>
			
			<a href=admin_login.php target = RESULT><font face=verdana size=2>- des utilisateurs
			<br><br>
			<a href=admin_activite.php target = RESULT><font face=verdana size=2>- des activités
			<br><br>
			<a href=admin_equipement.php target = RESULT><font face=verdana size=2>- des équipements
			<br><br>
			<a href=admin_frequence.php target = RESULT><font face=verdana size=2>- des fréquences
			<br><br>
			<a href=admin_secteur.php target = RESULT><font face=verdana size=2>- des secteurs
			<br><br>
			
			</td>
  		</tr>
		
		</center></table>";



$result = odbc_close($connexion);
}
?>
</html>