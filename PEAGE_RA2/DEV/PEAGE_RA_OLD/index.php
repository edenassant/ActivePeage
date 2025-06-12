<html>

<head><link href=style.css rel=stylesheet type=text/css></head>
<style>
        body {
            zoom: 100%; /* Modifier la valeur pour ajuster le niveau de zoom */
        }
    </style>
<?php

require ("connexion.php");

if ($connexion) {


   echo "<center><font face=verdana size=6><b>Bienvenue dans l'application <br><br>Rungis Accueil version Péage</b></center><br>";
   //echo "<center><font face=verdana size=3><b>Veuillez saisir votre login et mot de passe</b></center><br>";
   
	

   echo"<center><table border=1>";
  echo"<tr>";
    echo"<td align=center><image src=logo.jpg></td>";
    echo"<td>";
	
  echo "<center><table border = 0>";
   echo "<form method=post action=validate.php>";

   echo "<input type=hidden name=etat value=valider>";
   
  echo "<tr>
          <td align=left><font face=verdana size=2>Login</font></td>
          <td><input type=text name=login maxlength=20 size=30></td>
       </tr>";
  echo "<tr>
          <td align=left><font face=verdana size=2>Mot de passe</font></td>
          <td><input type=password name=password maxlength=20 size=30></td>
       </tr>";
   echo "<tr>
          <td colspan=2 align=center>
           <br><input type=submit value=valider>
          </td>
        </tr>";
	echo "</form></table></center>";
	echo"</td></tr></table>";
	
	echo"<br><br><br>";
	echo "<center><font face=verdana size=2><b>SEMMARIS - Service Informatique - Version : 2</b></center><br>";



}
$result = odbc_close($connexion);
?>

</html>