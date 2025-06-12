<?php

require ("connexion.php");
$c_code = isset($_POST['c_code']) ? $_POST['c_code'] : '';
$ca_code = isset($_POST['ca_code']) ? $_POST['ca_code'] : '';
//isset = variable nulle
	//echo"$c_code";
	// recherche info client
//get on recupere des données et post on envoie au serveur

$requete = "SELECT c.c_code, c_rs, c_statut , a_lib, cat_lib,  c.cat_code , convert(char(10), c_date_fin_validite,103) as c_date_fin_validite ,convert(char(10), c_date_cloture,103) as c_date_cloture 
, c_alertesms, c_tel,
convert(varchar(60), LTRIM( isnull(convert(varchar(4),C_NUM_VOIE_F), ' ') + ' ' + LTRIM(f.REP_LIB + ' ' + LTRIM(e.TV_LIB + ' ' + C_NOM_VOIE_F)))) as  AdresseF,
convert(varchar(60), LTRIM( isnull(convert(varchar(50),C_CPLT_VOIE_F), ' ') + ' ' + LTRIM(C_CPLT_VOIE2_F + ' '  + C_CPLT_VOIE3_F))) as  ComplementF
,c_cp_f ,c_commune_f, d.PAYS_LIB AS PAYS_LIB_F
FROM CLIENT c  
LEFT OUTER JOIN TYPE_VOIE a on 	a.TV_CODE = TV_CODE_S
LEFT OUTER JOIN REP b on b.REP_CODE = REP_CODE_S
LEFT OUTER JOIN dbo.PAYS d on d.pays_CODE = pays_CODE_S
LEFT OUTER JOIN TYPE_VOIE e on 	e.TV_CODE = TV_CODE_F
LEFT OUTER JOIN REP f on f.REP_CODE = REP_CODE_F
LEFT OUTER JOIN PAYS g on g.pays_CODE = pays_CODE_F
, cat h , activite i 
			where c.cat_code = h.cat_code
			and	c.a_code = i.a_code 
			and c.C_CODE = $c_code ";			

	$resultat = odbc_exec($connexion,$requete);
		
		$codeclient = odbc_result($resultat,"C_CODE");
		$raisonsociale = odbc_result($resultat,"c_rs");
		$statut = odbc_result($resultat,"c_statut");
		$activite = odbc_result($resultat,"a_lib");
		$cat_lib = odbc_result($resultat,"cat_lib");
		$cat_code = odbc_result($resultat,"cat_code");
		$finvalidite = odbc_result($resultat,"c_date_fin_validite");
		$datecloture = odbc_result($resultat,"c_date_cloture");
		$cp = odbc_result($resultat,"c_cp_f");
		$ville = odbc_result($resultat,"c_commune_f");
		$portable = odbc_result($resultat,"c_alertesms");
		$tel = odbc_result($resultat,"c_tel");
		$adresse = odbc_result($resultat,"AdresseF");
		$cplt = odbc_result($resultat,"ComplementF");
		
		
		echo "<table width = 100% border=1>";

		echo"<td width = 25%>";
			
   			echo "<table width = 100% border=0>";
			
				
				//echo "<tr><td colspan=2 align=center><font face=verdana color= red size=3>informations client</font></td></tr>";
				//echo "<tr><td><HR></td><td><HR></td></tr>";
				echo "<tr>
				<td width = 40%><font face=verdana size=2><b>code client : </b></font></td>
				<td width = 60%><font face=verdana size=3>$codeclient </font></td>
				</tr>		
				<tr>
				<td width = 40%><font face=verdana size=2><b>Raison sociale : </b></font></td>
				<td width = 60%><font face=verdana size=3>$raisonsociale</font></td>
				</tr>";
				if ( $cat_code == 1)
				{	echo "<tr>
					<td width = 40%><font face=verdana size=2><b>Catégorie : </b></font></td>
					<td width = 60%><font face=verdana color= red size=3><b>$cat_lib</b></font></td>
					</tr>";
				}
				else
				{	echo "<tr>
					<td width = 40%><font face=verdana size=2><b>Catégorie : </b></font></td>
					<td width = 60%><font face=verdana size=3>$cat_lib</font></td>
					</tr>";
				}
				echo "<tr>
				<td width = 40%><font face=verdana size=2><b>Activité : </b></font></td>
				<td width = 60%><font face=verdana size=3>$activite</font></td>
				</tr>";
				
				if ( $cat_code > 1)
				{	echo "<tr>
					<td width = 40%><font face=verdana size=2><b>Date de fin de validité : </b></font></td>
					<td width = 60%><font face=verdana size=3>$finvalidite </font></td>
					</tr>";	
				}
				else
				{	echo "<tr>
					<td width = 40%><font face=verdana size=2><b>Date de fin de validité : </b></font></td>
					<td width = 60%><font face=verdana size=3> </font></td>
					</tr>";	
				}				
				
   			echo "</table>";	
		echo"</td>";
		
		echo"<td width =25%>";
   			echo "<table width = 100% border=0>";
						
			echo "<tr>
				<td width = 40%><font face=verdana size=2><b>Portable entreprise : </b></font></td>
				<td width = 60%><font face=verdana size=3>$portable </font></td>
				</tr>		
				<tr>
				<td width = 40%><font face=verdana size=2><b>Téléphone entreprise : </b></font></td>
				<td width = 60%><font face=verdana size=3>$tel</font></td>
				</tr>";		

			echo "<tr>
				<td width = 40%><font face=verdana size=2><b>Adresse facturation : </b></font></td>
				<td width = 60%><font face=verdana size=3>$adresse </font></td>
				</tr>		
				<tr>
				<td width = 40%><font face=verdana size=2><b></b></font></td>
				<td width = 60%><font face=verdana size=3>$cplt</font></td>
				</tr><tr>
				<td width = 40%><font face=verdana size=2><b></b></font></td>
				<td width = 60%><font face=verdana size=3>$cp $ville</font></td>
				</tr>";		

		

			echo "</table>";	
		echo"<td width = 10%>";
   			echo "<table width = 100% border=0>";
			
			if ( $statut == 'ACTIF')
				{		
					echo"
					<tr>
					<td align=center width = 60%><font face=verdana size=3><br></font></td>
					</tr>
					<tr>
					<td align=center width = 60%><font face=verdana size=6><b>$statut</b></font></td>
					</tr>";
				}
				else
				{
					if ( $statut == 'PERIME')
					{		
						
						echo"
						<tr>
						<td align=center width = 60%><font face=verdana size=3><br></font></td>
						</tr>
						<tr>
						<td align=center width = 60%><font face=verdana color= blue size=6><b>$statut le $datecloture</b></font></td>
						</tr>";
					}
					else
					{	
						if ( $statut == 'EN COURS')
						{		
						
							echo"
							<tr>
							<td align=center width = 60%><font face=verdana size=3><br></font></td>
							</tr>
							<tr>
							<td align=center width = 60%><font face=verdana color= orange size=6><b>$statut</b></font></td>
							</tr>";
						}
						else
						{	
							echo"
							<tr>
							<td align=center width = 60%><font face=verdana size=3><br></font></td>
							</tr>
							<tr>
							<td align=center width = 60%><font face=verdana color= red size=6><b>$statut le $datecloture</b></font></td>
							</tr>";
						}
					}
				}
			//echo</tr>";
   			echo "</table>";	

		echo"<td width = 20%>";
			echo "<table width = 100% border=0>";
   		// affichage des alertes SMS clients lié à la carte
		
				echo "<tr><td colspan=4 align=center><font face=verdana color= red size=2>Alerte Mail et SMS</font></td></tr>";
				//echo "<tr><td><HR></td><td><HR></td><td><HR></td></tr>";
				echo "<tr>
					<td align=left><font face=verdana size=2><b>date </b></font></td>
					<td align=left><font face=verdana size=2><b>heure</b></font></td>
					<td align=left><font face=verdana size=2><b>message</b></font></td>
				</tr>";
	
	echo "<tr>
						<td align=left><font face=verdana size=1></font></td>
						<td align=left><font face=verdana color= red size=5>A DEFINIR</font></td>
						<td align=left><font face=verdana size=1></font></td>
					</tr>";
	
				$requete1 = "select  top(5) convert(char(10),wa_date_creation,103) as date , convert(char(5),wa_date_creation,108) as heure, wa_lib_court from web_alerte 
					where C_CODE = $c_code  
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
						<td align=left><font face=verdana size=1></font></td>
						<td align=left><font face=verdana size=1>A DEFINIR</font></td>
						<td align=left><font face=verdana size=1></font></td>
					</tr>";
				}   			

			//*/ fin affichage alerte client
   			echo "</table>";	
		  echo"</td>";
			
		
		echo"</td>";

// test probléme connexion bridge



echo"<td width = 20%>";
			
   			echo "<table width = 100% border=0>";
			
			// affichage des pass express
			
			require ("connexion_bridge.php");
			
				
			$requete7 = "SELECT ID,C_CODE,convert(char(16), DATE_START_VALID,103) as DATE_START_VALID, DATE_END_VALID, convert(char(10), DATE_USED,103) as DATE_USED,
						convert(char(5), DATE_USED,108) as DATE_USED_HEURE
						FROM BARCODES where type_of_card = 12	
						and datediff(dd, DATE_END_VALID, getdate()) < 730
						and C_CODE = $c_code order by DATE_START_VALID desc";
											
									

			$resultat7 = odbc_exec($connexion_bridge,$requete7);

			echo "<tr><td colspan=3 align=center><font face=verdana color= red size=2>Pass Express valide 2 ans </font></td></tr>";
				//echo "<tr><td><HR></td><td><HR></td><td><HR></td></tr>";
				
			echo "<tr>
					<td align=left><font face=verdana size=1><b>ID du ticket  </b></font></td>
					<td align=left><font face=verdana size=1><b>Date de début </b></font></td>
					<td align=left><font face=verdana size=1><b>Date d'utilisation </b></font></td>
				</tr>";

				while (odbc_fetch_row($resultat7))
   			{
		
				$ID = odbc_result($resultat7,"ID");
				$date_start = odbc_result($resultat7,"DATE_START_VALID");
				$date_used = odbc_result($resultat7,"DATE_USED");
				$date_used_heure = odbc_result($resultat7,"DATE_USED_HEURE");

				
				echo "<tr>
					<td align=left><font face=verdana size=1>$ID  </font></td>
					<td align=left><font face=verdana size=1>$date_start</font></td>
					<td align=left><font face=verdana size=1>$date_used $date_used_heure</font></td>
				</tr>";
			}		
				
   			echo "</table>";	
					
		echo"</td>";
		echo "</table>";
	
	
	
			
?>		
		