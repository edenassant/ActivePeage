<?php
$c_code= isset($_REQUEST['c_code']) ? $_REQUEST['c_code'] : '';
$ca_code=isset($_REQUEST['ca_code']) ? $_REQUEST['ca_code'] : '';
$nom=isset($_REQUEST['nom']) ? $_REQUEST['nom'] : '';
require ("connexion.php");

	// visualisation de tous les clients contenant la saisi

	$requete = "SELECT distinct a.c_code, c_rs, c_enseigne, c_statut, a_lib, cat_lib, convert(char(10),c_date_fin_validite,103) as  c_date_fin_validite, c_cp_f, c_commune_f ,
				cor_nom + ' ' + cor_prenom as nom_corres from client a 
				left outer join correspondant d on a.c_code = d.c_code
				, cat b , activite c 
				where a.cat_code = b.cat_code
				and	a.a_code = c.a_code 
				and 	( c_rs like '%$nom%' or c_enseigne like '%$nom%' or COR_nom like '%$nom%' ) order by c_code desc";

	$resultat = odbc_exec($connexion,$requete);
		
		
	
	echo"<br>";	
	echo "<center><font face=verdana size=3>Liste des clients</a>";	
	echo"<br>";
	
	echo "<center><table border=1><tr>
			<th><font face=verdana size=1>Numéro client</font></th>
			<th><font face=verdana size=1>Raison sociale</font></th>
			<th><font face=verdana size=1>Enseigne</font></th>
			<th><font face=verdana size=1>Correspondant</font></th>
			<th><font face=verdana size=1>Catégorie</font></th>
			<th><font face=verdana size=1>Activité/font></th>
			<th><font face=verdana size=1>Date de fin de validité</font></th>
			<th><font face=verdana size=1>Code postal</font></th>
			<th><font face=verdana size=1>Ville</font></th>
			<th><font face=verdana size=1>Statut</font></th>
			</tr>";


	while (odbc_fetch_row($resultat))
   	{
    	$c_code = odbc_result($resultat,"C_CODE");
		$raisonsociale = odbc_result($resultat,"c_rs");
		$enseigne = odbc_result($resultat,"c_enseigne");
		$corres = odbc_result($resultat,"nom_corres");
		$statut = odbc_result($resultat,"c_statut");
		$activite = odbc_result($resultat,"a_lib");
		$cat_lib = odbc_result($resultat,"cat_lib");
		$finvalidite = odbc_result($resultat,"c_date_fin_validite");
		$cp = odbc_result($resultat,"c_cp_f");
		$ville = odbc_result($resultat,"c_commune_f");
	
		if ( !trim($cp)  ) { $cp = "-" ; }		
		if ( !trim($ville)  ) { $ville = "-" ; }		
			
				
		echo "<tr>
			<td><center><font face=verdana size=1>$c_code</font></td>
			<td><center><font face=verdana size=1>$raisonsociale </font></td>
			<td><center><font face=verdana size=1>$enseigne </font></td>
			<td><center><font face=verdana size=1>$corres </font></td>
			<td><center><font face=verdana size=1>$cat_lib </font></td>
			<td><center><font face=verdana size=1>$activite</font></td>
			<td><center><font face=verdana size=1>$finvalidite</font></td>
			<td><center><font face=verdana size=1>$cp</font></td>
			<td><center><font face=verdana size=1>$ville</font></td>";
					
		if ( $statut == 'ACTIF')
		{		
			echo"<td align=center><font face=verdana size=1><b>$statut</b></font></td>";
		}
		else
		{
			if ( $statut == 'CLOTURE')
			{		
				echo"<td align=center><font face=verdana color= red size=1><b>$statut</b></font></td>";
			}
			else
			{
				if ( $statut == 'PERIME')
				{		
					echo"<td align=center><font face=verdana color= blue size=1><b>$statut</b></font></td>";
				}
				else
				{
					echo"<td align=center><font face=verdana color= orange size=1><b>$statut</b></font></td>";
				}			
			}			
		}		
     	echo "<td><center><font face=verdana size=1><a href=frontal.php?c_code=$c_code&action=liste&ca_code=$ca_code title='Voir les détail du client'><image src=lien.jpg></font></a></td>";
				    	
	}
	echo "</tr></center></table>	";

?>		
		