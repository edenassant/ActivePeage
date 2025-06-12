<?php

require ("connexion.php");
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
$c_code = isset($_REQUEST['c_code']) ? $_REQUEST['c_code'] : '';
$ca_code = isset($_REQUEST['ca_code']) ? $_REQUEST['ca_code'] : '';
//$c_code = isset($_POST['c_code']) ? $_POST['c_code'] : '';
//$ca_code = isset($_POST['ca_code']) ? $_POST['ca_code'] : '';
	//echo"$c_code";
	//echo"$ca_code";
	// recherche info client
	$requete2 = "SELECT c_code, ca_code, tcarte_lib,ca_champ_1,ca_champ_2, ca_champ_3, ca_valid, ca_ln, rln_lib, clas_lib,
			convert(char(10),ca_date_valid,103) as ca_date_valid, ca_nbre_passage, ca_immatriculation, ca_immat_peage_autorise, ca_statut , a.tcarte_code 
			from carte as a left outer join raison_ln as d on a.rln_code = d.rln_code , classe b , type_carte c
			where a.clas_code=b.clas_code
			and	a.tcarte_code = c.tcarte_code
			and	C_CODE = '$c_code'
			and ca_code = '$ca_code'";

	$resultat2 = odbc_exec($connexion,$requete2);
		
			$ca_code = odbc_result($resultat2,"ca_code");
			$typecarte = odbc_result($resultat2,"tcarte_lib");
			$libre1 = odbc_result($resultat2,"ca_champ_1");
			$libre2 = odbc_result($resultat2,"ca_champ_2");
			$libre3 = odbc_result($resultat2,"ca_champ_3");	
			$actif = odbc_result($resultat2,"ca_valid");
			$ln = odbc_result($resultat2,"ca_ln");
			$lnmotif = odbc_result($resultat2,"rln_lib");
			$classe = odbc_result($resultat2,"clas_lib");
			$datefin = odbc_result($resultat2,"ca_date_valid");
			$pts = odbc_result($resultat2,"ca_nbre_passage");
			$immat = odbc_result($resultat2,"ca_immatriculation");
			$lectureplaque = odbc_result($resultat2,"ca_immat_peage_autorise");
			$statut = odbc_result($resultat2,"ca_statut");
			$tcarte_code = odbc_result($resultat2,"tcarte_code");
			
			if ( $pts ==999 ) { $pts = ""; }
			
			if ( $lectureplaque == 1 ) { $lectureplaque = "OUI"; } else  { $lectureplaque = "NON" ;}		

		echo"<br>";	
		echo "<center><font face=verdana size=3>Détails de la carte N° $ca_code</a>";	
		echo"<br><br>";	
	

		echo "<table width = 100% border=1>";

		echo"<td width = 31%>";
			echo "<table width = 100% border=0>";
			
			// affichage des informations de la carte
				echo "<tr><td colspan=2 align=center><font face=verdana color= red size=2>Informations de la carte</font></td></tr>";
				echo "<tr><td width = 40%><HR></td><td width = 60%><HR></td></tr>";
				
				
			
				echo "
				<tr>
				<td width = 40%><font face=verdana size=2><b>numero carte : </b></font></td>
				<td width = 60%><font face=verdana size=2>$ca_code </font></td>
				</tr>
				<tr>
				<td width = 40%><font face=verdana size=2><b>Type de carte : </b></font></td>
				<td width = 60%><font face=verdana size=2>$typecarte</font></td>
				</tr>";
				if ( $pts > 0 )
				{ 
				echo "<tr>
				<td width = 40%><font face=verdana size=2><b>Nombre d'entrées : </b></font></td>
				<td width = 60%><font face=verdana size=3><b>$pts</b></font></td>
				</tr>";
				}
				else
				{ 
				echo "<tr>
				<td width = 40%><font face=verdana size=2><b>Nombre d'entrées : </b></font></td>
				<td width = 60%><font face=verdana color = red size=3><b>$pts</b></font></td>
				</tr>";
				}
				
				echo "<tr>
				<td width = 40%><font face=verdana size=2><b>Date de fin : </b></font></td>
				<td width = 60%><font face=verdana size=2>$datefin</font></td>
				</tr>
				<tr>
				<td width = 40%><font face=verdana size=2><b>Immatriculation : </b></font></td>
				<td width = 60%><font face=verdana size=2>$immat</font></td>
				</tr>
				<tr>
				<td width = 40%><font face=verdana size=2><b>Lecture plaque autorisée : </b></font></td>
				<td width = 60%><font face=verdana size=2>$lectureplaque</font></td>
				</tr>
				<tr>
				<td width = 40%><font face=verdana size=2><b>libre1 : </b></font></td>
				<td width = 60%><font face=verdana size=2>$libre1</font></td>
				</tr>
				<tr>
				<td width = 40%><font face=verdana size=2><b>libre2 : </b></font></td>
				<td width = 60%><font face=verdana size=2>$libre2</font></td>
				</tr>
				<tr>
				<td width = 40%><font face=verdana size=2><b>libre3 : </b></font></td>
				<td width = 60%><font face=verdana size=2>$libre3 </font></td>
				</tr>
				<tr>
				<td width = 40%><font face=verdana size=2><b>Classe : </b></font></td>
				<td width = 60%><font face=verdana size=2>$classe</font></td>
				</tr>";
			
				if ( $actif == 1 )
				{ 	
					echo "<tr>	
					<td width = 40%><font face=verdana size=2><b>Carte Active : </b></font></td>
					<td width = 60%><font face=verdana size=2>OUI </font></td>
					</tr>";
				}
				else
				{
					if ( $statut == 'A_ACTIVER' )   
					{
					echo"<td width = 40%><font face=verdana color= red size=3><b>CARTE PROVISOIRE</b></font></td>";
					echo"<td width = 60%><font face=verdana  color= red  size=3><b>Ne pas autoriser le passage</b></font></td>";
					}
					else
					{
					$requete3 = "SELECT * from carte a, RAISON_CARTE_INACTIVE b
					where a.RCI_CODE = b.RCI_CODE 
						and	C_CODE = '$c_code'
						and	ca_code = '$ca_code' ";

				

					$resultat3 = odbc_exec($connexion,$requete3);

					$lib = odbc_result($resultat3,"rci_lib");					
					
					echo "<tr>	
					<td width = 40%><font face=verdana size=3><b>Carte Active : </b></font></td>
					<td width = 60%><font face=verdana color= red size=3><b>NON / $lib</b></font></td>
					</tr>";	
					}
				}
				
				if ( $ln == 1 )
				{ 		
					echo "<tr>	
					<td width = 40%><font face=verdana size=3><b>Carte en Liste Noire : </b></font></td>
					<td width = 60%><font face=verdana color= red size=3><b>OUI  / $lnmotif</b></font></td>
					</tr>";
				}
				else
				{
					echo "<tr>	
					<td width = 40%><font face=verdana size=2><b>Carte en Liste Noire : </b></font></td>
					<td width = 60%><font face=verdana size=2>NON</font></td>
					</tr>";
				}
				

			

			echo "</table>";	
   			
		echo"</td>";
		
		if ( $tcarte_code  < 3 )
		{
		 // affichage des passages de la carte
		echo"<td width = 23%>";
   			echo "<table width = 100% border=0>";
			
				echo "<tr><td colspan=3 align=center><font face=verdana color= red size=2>Derniers passages de la carte</font></td></tr>";
				echo "<tr><td><HR></td><td><HR></td><td><HR></td><td><HR></td><td><HR></td></tr>";
				
			$requete4 = "SELECT top(13) hpc_date , convert(char(10),hpc_date,103) as date , convert(char(8),hpc_date,108) as heure, voie_num, gare_num, clasdect, HPC_SOLDE_PTS  
			from AboBackup1.dbo.histo_pass_carte_annee_cour
				where 
					C_CODE = '$c_code'
				and 	ca_code = '$ca_code'
				order by hpc_date desc ";

			$resultat4 = odbc_exec($connexion,$requete4);
				
				echo "<tr>
					<td align=left><font face=verdana size=2><b>date  </b></font></td>
					<td align=left><font face=verdana size=2><b>heure</b></font></td>
					<td align=left><font face=verdana size=2><b>voie</b>  </font></td>
					<td align=center><font face=verdana size=1><b>solde<br>Entrées</b></font></td>
					<td align=center><font face=verdana size=1><b>Autorisation<br>péager  </b></font></td>
				</tr>";

				while (odbc_fetch_row($resultat4))
   			{
		
				$ca_code = odbc_result($resultat4,"ca_code");
				$date = odbc_result($resultat4,"date");
				$heure = odbc_result($resultat4,"heure");
				$voie = odbc_result($resultat4,"voie_num");
				$clasdect = odbc_result($resultat4,"clasdect");	
				$AutorisationPeager = odbc_result($resultat4,"HPC_SOLDE_PTS");	
				$solde = odbc_result($resultat4,"HPC_SOLDE_PTS");
				
				if ( $AutorisationPeager == 992 ) { $AutorisationPeager = "Oui"; } else  { $AutorisationPeager = "" ;}		

				echo "<tr>
					<td align=left><font face=verdana size=1>$date  </font></td>
					<td align=left><font face=verdana size=1>$heure</font></td>
					<td align=left><font face=verdana size=1>$voie  </font></td>
					<td align=center><font face=verdana size=1>$solde  </font></td>
					<td align=center><font face=verdana size=1>$AutorisationPeager</font></td>
				</tr>";

			}

			echo "</table>";	
		 echo"</td>";
		}
		else
		{
			 // affichage tableau recap sur les 6 derniers mois des autorisations de passages
		echo"<td width = 23%>";
   			echo "<table width = 100% border=0>";
			
				echo "<tr><td colspan=3 align=center><font face=verdana color = red size=2>Nombre d'autorisations de passages par mois</font></td></tr>";
				echo "<tr><td><HR></td><td><HR></td><td><HR></td></tr>";
			
			echo "<tr>
					<td align=left><font face=verdana size=2><b><br>mois  </b></font></td>
					<td align=center><font face=verdana size=2><b>Nombre de<br> passages<br> avec cartes</b>  </font></td>
					<td align=center><font face=verdana size=2><b>Nombre <br>d'autoristion <br>de passages</b></font></td>
					</tr>";

				echo "<tr><td><br></td></tr>";			
			
			
			// affichage mois en cours

			$requete4 = "SELECT convert(char(2),hpc_date,110) as mois,  DATENAME (year, convert(datetime,a.HPC_DATE,103)) as an, 
						count((CASE WHEN(HPC_SOLDE_PTS <> 992 ) THEN 1 ELSE NULL END) ) as pass_cartes
						,count((CASE WHEN(HPC_SOLDE_PTS = 992 ) THEN 1 ELSE NULL END) ) as pass_Autorisation
				from  AboRungis.dbo.histo_pass_carte a 
				where  DATEDIFF( M , a.hpc_date ,getdate()) = 0
				and 	C_CODE = '$c_code'
				and 	ca_code = '$ca_code'
				group by convert(char(2),hpc_date,110),  DATENAME (year, convert(datetime,a.HPC_DATE,103))
				order by DATENAME (year, convert(datetime,a.HPC_DATE,103)) desc , convert(char(2),hpc_date,110) desc";

			$resultat4 = odbc_exec($connexion,$requete4);
			
			while (odbc_fetch_row($resultat4))
   			{
		
				//$mois = ;
				
				switch (odbc_result($resultat4,"mois") ) {
				case '01': $mois = 'Janvier'; break;
				case '02': $mois = 'Février'; break;
				case '03': $mois = 'Mars'; break;
				case '04': $mois = 'avril'; break;
				case '05': $mois = 'Mai'; break;
				case '06': $mois = 'juin'; break;
				case '07': $mois = 'Juillet'; break;
				case '08': $mois = 'aout'; break;
				case '09': $mois = 'Septembre'; break;
				case '10': $mois = 'Octobre'; break;
				case '11': $mois = 'Novembre'; break;
				case '12': $mois = 'Décembre'; break;
				
   
				}
				
				
				
				$an = odbc_result($resultat4,"an");
				$pass_cartes = odbc_result($resultat4,"pass_cartes");
				$pass_Autorisation = odbc_result($resultat4,"pass_Autorisation");
								
				echo "<tr>
					<td align=left><font face=verdana size=2>$mois $an  </font></td>
					<td align=center><font face=verdana size=2>$pass_cartes</font></td>
					<td align=center><font face=verdana size=2>$pass_Autorisation  </font></td>
					
					</tr>";

			}
			
			// affichage par mois -1 sur AboBackup1 

						


			$requete4 = "SELECT convert(char(2),hpc_date,110) as mois,  DATENAME (year, convert(datetime,a.HPC_DATE,103)) as an, 
						count((CASE WHEN(HPC_SOLDE_PTS <> 992 ) THEN 1 ELSE NULL END) ) as pass_cartes
						,count((CASE WHEN(HPC_SOLDE_PTS = 992 ) THEN 1 ELSE NULL END) ) as pass_Autorisation
				from  AboBackup1.dbo.histo_pass_carte_annee_cour a 
				where  DATEDIFF( M , a.hpc_date ,getdate()) between 1 and  6 
				and 	C_CODE = '$c_code'
				and 	ca_code = '$ca_code'
				group by convert(char(2),hpc_date,110),  DATENAME (year, convert(datetime,a.HPC_DATE,103))
				order by DATENAME (year, convert(datetime,a.HPC_DATE,103)) desc , convert(char(2),hpc_date,110) desc";

			$resultat4 = odbc_exec($connexion,$requete4);
			
			while (odbc_fetch_row($resultat4))
   			{
		
				//$mois = ;
				
				switch (odbc_result($resultat4,"mois") ) 
				{
				case '01': $mois = 'Janvier'; break;
				case '02': $mois = 'Février'; break;
				case '03': $mois = 'Mars'; break;
				case '04': $mois = 'avril'; break;
				case '05': $mois = 'Mai'; break;
				case '06': $mois = 'juin'; break;
				case '07': $mois = 'Juillet'; break;
				case '08': $mois = 'Aout'; break;
				case '09': $mois = 'Septembre'; break;
				case '10': $mois = 'Octobre'; break;
				case '11': $mois = 'Novembre'; break;
				case '12': $mois = 'Décembre'; break;
  
				}
				
				
				
				$an = odbc_result($resultat4,"an");
				$pass_cartes = odbc_result($resultat4,"pass_cartes");
				$pass_Autorisation = odbc_result($resultat4,"pass_Autorisation");
								
			
				echo "<tr>
					<td align=left><font face=verdana size=2>$mois $an  </font></td>
					<td align=center><font face=verdana size=2>$pass_cartes</font></td>
					<td align=center><font face=verdana size=2>$pass_Autorisation  </font></td>
					
					</tr>";

			}
			
			// affichage du total 

			// total des six derniers mois sauf mois en cours	
			$requete5 = "SELECT count((CASE WHEN(HPC_SOLDE_PTS <> 992 ) THEN 1 ELSE NULL END) ) as pass_cartes
						,count((CASE WHEN(HPC_SOLDE_PTS = 992 ) THEN 1 ELSE NULL END) ) as pass_Autorisation
				from  AboBackup1.dbo.histo_pass_carte_annee_cour a 
				where  DATEDIFF( M , a.hpc_date ,getdate()) between 1 and  6  
				and 	C_CODE = '$c_code'
				and 	ca_code = '$ca_code'";

			$resultat5 = odbc_exec($connexion,$requete5);
			
					
				$pass_cartes1 = odbc_result($resultat5,"pass_cartes");
				$pass_Autorisation1 = odbc_result($resultat5,"pass_Autorisation");
			
			// mois en cours
			$requete6 = "SELECT count((CASE WHEN(HPC_SOLDE_PTS <> 992 ) THEN 1 ELSE NULL END) ) as pass_cartes
						,count((CASE WHEN(HPC_SOLDE_PTS = 992 ) THEN 1 ELSE NULL END) ) as pass_Autorisation
				from  AboRungis.dbo.histo_pass_carte a 
				where  DATEDIFF( M , a.hpc_date ,getdate()) = 0  
				and 	C_CODE = '$c_code'
				and 	ca_code = '$ca_code'";

			$resultat6 = odbc_exec($connexion,$requete6);
			
					
				$pass_cartes2 = odbc_result($resultat6,"pass_cartes");
				$pass_Autorisation2 = odbc_result($resultat6,"pass_Autorisation");
				
			
			//total des 2
			
			$pass_cartes = $pass_cartes1 + $pass_cartes2;
			$pass_Autorisation = $pass_Autorisation1 + $pass_Autorisation2;
			
				echo "<tr>
					<td align=left><font face=verdana size=2><b>Total passages</b></font></td>
					<td align=center><font face=verdana size=2><b>$pass_cartes</b></font></td>
					<td align=center><font face=verdana size=2><b>$pass_Autorisation</b></font></td>
					
					</tr>";

			
			echo "</table>";	
		 echo"</td>";
		
		}

		echo"<td width = 23%>";
   			echo "<table width = 100% border=0 vertical-align:top>";
			
			// affichage des historiques de la carte
				echo "<tr><td colspan=4 align=center><font face=verdana color= red size=2>Historique de la carte</font></td></tr>";
				echo "<tr><td><HR></td><td><HR></td><td><HR></td><td><HR></td></tr>";
				
			$requete5 = "SELECT convert(char(13),hc_date,103) as date , convert(char(8),hc_date,108) as heure , ta_lib , hc_cplt, hc_nb_pts , AGENT_ID, a.ta_code
						from histo_carte a , type_action b
						where 	a.ta_code = b.ta_code 
						and TA_VISIBLE_WEB = 1
						and	C_CODE = '$c_code'
						and 	ca_code = '$ca_code'
						order by hc_date desc ";

			$resultat5 = odbc_exec($connexion,$requete5);
				echo "<tr>
					<td align=left><font face=verdana size=2><b>date  </b></font></td>
					<td align=left><font face=verdana size=2><b>heure</b></font></td>
					<td align=left><font face=verdana size=2><b>action  </b></font></td>
					<td align=left><font face=verdana size=2><b>Nb Entrées</b></font></td>
				</tr>";

				while (odbc_fetch_row($resultat5))
   			{
		
				$date = odbc_result($resultat5,"date");
				$heure = odbc_result($resultat5,"heure");
				$lib = odbc_result($resultat5,"ta_lib");
				$pts = odbc_result($resultat5,"hc_nb_pts");	
				$agent = odbc_result($resultat5,"agent_id");	
				$ta_code = odbc_result($resultat5,"ta_code");	
				
				if ( $pts ==999 ) { $pts = ""; }
				
				if ( $agent == 81 ) 
				{ 
					if ( $ta_code == 13 ) { $lib = "Chargement Péage" ; }
				
				}
				
				echo "<tr>
					<td align=left><font face=verdana size=1>$date  </font></td>
					<td align=left><font face=verdana size=1>$heure</font></td>
					<td align=left><font face=verdana size=1>$lib  </font></td>
					<td align=center><font face=verdana size=1>$pts </font></td>
				</tr>";

			}

   			echo "</table>";	
		  echo"</td>";

		echo"<td width = 23%>";
   			echo "<table width = 100% border=0>";
				// affichage des alertes SMS clients lié à la carte
		
				echo "<tr><td colspan=4 align=center><font face=verdana color= red size=2>Alerte SMS</font></td></tr>";
				echo "<tr><td><HR></td><td><HR></td><td><HR></td></tr>";
				echo "<tr>
					<td align=left><font face=verdana size=2><b>date </b></font></td>
					<td align=left><font face=verdana size=2><b>heure</b></font></td>
					<td align=left><font face=verdana size=2><b>message</b></font></td>
				</tr>";
	
				$requete1 = "SELECT  top(5) convert(char(10),wa_date_creation,103) as date , convert(char(5),wa_date_creation,108) as heure, wa_lib_court from web_alerte 
					where C_CODE = '$c_code'  
					and wtsa_code = 4 
					and substring(wa_lib_long, 7, 3 ) = '$ca_code' 
					order by wa_code desc ";
				$resultat1 = odbc_exec($connexion,$requete1);
		
				while (odbc_fetch_row($resultat1))
   				{
					$heure = odbc_result($resultat1,"heure");
					$date = odbc_result($resultat1,"date");
					$waalerte = odbc_result($resultat1,"wa_lib_court");
								
					echo "<tr>
						<td align=left><font face=verdana size=1>$date</font></td>
						<td align=left><font face=verdana size=1>$heure</font></td>
						<td align=left><font face=verdana size=1>$waalerte</font></td>
					</tr>";
				}   			

			//*/ fin affichage alerte client
   			echo "</table>";	
		  echo"</td>";
	echo "</table>";
	
	
	echo"<tr>
	<td>
	<br>
	</td>
	</tr>
	<tr>
	<td><center><font face=verdana size=3><a href=frontal.php?c_code=$c_code&action=liste&ca_code=$ca_code>Voir toutes les cartes du client</font></a></td></tr>";

?>		
		