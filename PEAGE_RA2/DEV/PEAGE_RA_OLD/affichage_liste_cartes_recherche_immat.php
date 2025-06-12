<?php

require ("connexion.php");
$codeclient = isset($_POST['c_code']) ? $_POST['c_code'] : '';
$c_code = isset($_POST['c_code']) ? $_POST['c_code'] : '';
$ca_code=isset($_POST['ca_code']) ? $_POST['ca_code'] : '';
	// visualisation de toutes les cartes d un client donne

	$requete2 = "SELECT * from carte as a left outer join raison_ln as d on a.rln_code = d.rln_code , classe b , type_carte c,  client e
			where 
				a.clas_code=b.clas_code
			and	a.tcarte_code = c.tcarte_code
			and 	a.c_code = e.c_code
			
			and UPPER(REPLACE(REPLACE(CA_IMMATRICULATION,'-',''),' ',''))like UPPER(REPLACE(REPLACE( '%$plaque%' ,'-',''),' ','')) order by a.c_code desc";

//--and	( ca_immatriculation like '%$plaque%' )
	$resultat2 = odbc_exec($connexion,$requete2);
		
		
	
	echo"<br>";	
	echo "<center><font face=verdana size=3>Liste des cartes</a>";	
	echo"<br>";
	
	 echo "<center><table border=1><tr>
			<th><font face=verdana size=1>Numéro client</font></th>
			<th><font face=verdana size=1>Raison sociale</font></th>
			<th><font face=verdana size=1>Numéro carte</font></th>
			<th><font face=verdana size=1>Type de carte</font></th>
			<th><font face=verdana size=1>Immatriculation</font></th>
			<th><font face=verdana size=1>Lecture plaque</font></th>
			<th><font face=verdana size=1>libre3</font></th>
			<th><font face=verdana size=1>Active</font></th>
			<th><font face=verdana size=1>Motif inactivité</font></th>
			<th><font face=verdana size=1>Liste noire</font></th>
			<th><font face=verdana size=1>Motif LN</font></th>
			<th><font face=verdana size=1>Classe</font></th>
			<th><font face=verdana size=1>Détails</font></th>
			</tr>";

		while (odbc_fetch_row($resultat2))
   		{
    		$codeclient = odbc_result($resultat2,"c_code");
			$c_rs = odbc_result($resultat2,"c_rs");
			$ca_code = odbc_result($resultat2,"ca_code");
			$typecarte = odbc_result($resultat2,"tcarte_lib");
			$libre1 = odbc_result($resultat2,"ca_champ_1");
			$libre2 = odbc_result($resultat2,"ca_champ_2");
			$libre3 = odbc_result($resultat2,"ca_champ_3");	
			$actif = odbc_result($resultat2,"ca_valid");
			$ln = odbc_result($resultat2,"ca_ln");
			$lnmotif = odbc_result($resultat2,"rln_lib");
			$classe = odbc_result($resultat2,"clas_lib");
			$statut = odbc_result($resultat2,"ca_statut");
			$immat = odbc_result($resultat2,"ca_immatriculation");
			$lectureplaque = odbc_result($resultat2,"ca_immat_peage_autorise");
			
			if ( !trim($libre1)  ) { $libre1 = "-" ; }								
			if ( !trim($libre2)  ) { $libre2 = "-" ; }	
			if ( !trim($libre3)  ) { $libre3 = "-" ; }	

				echo "<tr>
					<td><center><font face=verdana size=1>$codeclient</font></td>
					<td><center><font face=verdana size=1>$c_rs </font></td>
					<td><center><font face=verdana size=1>$ca_code </font></td>
					<td><center><font face=verdana size=1>$typecarte </font></td>
					<td><center><font face=verdana size=1>$immat </font></td>";
					
				if ( $lectureplaque == 1 )
				{ 		
					echo"<td><center><font face=verdana color= green  size=2><b>OUI</b></font></td>";
				}
				else
				{	
					echo"<td><center><font face=verdana size=1>NON</font></td>";
				}
				
				echo"<td><center><font face=verdana size=1>$libre3</font></td>";
					
					
				if ( $actif == 1 )
				{ 		
					echo"<td><center><font face=verdana color= green size=2><b>OUI</b></font></td>";
					echo"<td><center><font face=verdana size=1>-</font></td>";
					

				}
				else
				{
					if ( $statut == 'A_ACTIVER' )   
					{
					echo"<td><center><font face=verdana color= red size=2><b>PROVISOIRE</b></font></td>";
					echo"<td><center><font face=verdana  color= red  size=2><b>Ne pas autoriser le passage</b></font></td>";
					}
					else
					{
						echo"<td><center><font face=verdana size=2>NON</font></td>";
					
					//$requete3 = "select * from histo_carte
					//	where 
					//		ta_code = 7
					//	and	C_CODE = $c_code
					//	and 	hc_nb_pts is null 
					//	and	ca_code = $ca_code ";
					//$resultat3 = odbc_exec($connexion,$requete3);

					// $lib = odbc_result($resultat3,"hc_cplt");

					$requete3 = "SELECT * from carte a, RAISON_CARTE_INACTIVE b
					where a.RCI_CODE = b.RCI_CODE 
						and	C_CODE = $c_code 
						and	ca_code = $ca_code ";

					$resultat3 = odbc_exec($connexion,$requete3);

					$lib = odbc_result($resultat3,"rci_lib");			
			
					if ( !trim($lib)  ) { $lib = "-" ; }

					
			
					//echo"<td><center><font face=verdana color= red size=2><b>$lib</b></font></td>";
					echo"<td><center><font face=verdana size=2>$lib</font></td>";
					}
					
				}


				if ( $ln == 1 )
				{ 		
					echo"<td><center><font face=verdana  color= red size=2><b>OUI</b></font></td>
					<td><center><center><font face=verdana color= red size=2><b>$lnmotif</b></font></td>";
				}
				else
				{
					echo"<td><center><font face=verdana  size=1>NON</font></td>
					<td><center><center><font face=verdana size=1>-</font></td>";
				}


					
				echo"<td><center><font face=verdana size=1>$classe</font></td>
					<td><center><font face=verdana size=1><a href=frontal.php?c_code=$codeclient&action=details&ca_code=$ca_code title='Voir le détail de carte'><image src=lien.jpg></font></a></td>";
				    	 			
    		}
		 echo "</tr></center></table>";	
?>		
		