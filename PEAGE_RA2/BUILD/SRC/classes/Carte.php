<?php

class Carte {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }


    public function searchCartesByClient(string $c_code, bool $activite = false): array {
        $sql = "SELECT 
            a.c_code,
            a.ca_code,
            c.tcarte_lib,
            a.ca_champ_1,
            a.ca_champ_2,
            a.ca_champ_3,
            a.ca_valid,
            a.ca_ln,
            d.rln_lib,
            b.clas_lib,
            a.ca_statut,
            a.ca_immatriculation,
            a.ca_immat_peage_autorise,
            e.rci_lib 
        FROM carte a
        LEFT OUTER JOIN raison_ln d ON a.rln_code = d.rln_code
        JOIN classe b ON a.clas_code = b.clas_code
        JOIN type_carte c ON a.tcarte_code = c.tcarte_code
        LEFT OUTER JOIN RAISON_CARTE_INACTIVE e ON a.RCI_CODE = e.RCI_CODE
        WHERE a.c_code = :c_code";



        if($activite) {
        $sql .= " AND a.ca_valid = 1";
    }

    $sql .= " ORDER BY a.ca_code DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':c_code', $c_code, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère les cartes d'un client par son nom
     */
    public function searchCartesByRaisonSociale(string $nom): array {
        $sql = "SELECT distinct 
                    a.c_code,
                    c_rs,
                    c_enseigne, 
                    c_statut, 
                    a_lib,
                    cat_lib,
                    convert(char(10), c_date_fin_validite,103) as c_date_fin_validite, 
                    c_cp_f,
                    c_commune_f,
                    cor_nom + ' ' + cor_prenom as nom_corres
                from 
                    client a 
				    left outer join correspondant d on a.c_code = d.c_code,
                    cat b, 
                    activite c 
				where a.cat_code = b.cat_code
				and	a.a_code = c.a_code 
				and (c_rs like :nom1 or c_enseigne like :nom2 or COR_nom like :nom3 ) 
                order by c_code desc
        ";

        $stmt = $this->db->prepare($sql);
        $like = '%' . $nom . '%';
        $stmt->bindValue(':nom1', $like, PDO::PARAM_STR);
        $stmt->bindValue(':nom2', $like, PDO::PARAM_STR);
        $stmt->bindValue(':nom3', $like, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère les cartes d'une plaque
     */
    public function searchCartesByImmatriculation(string $plaque,bool $activite =false): array {
        $sql = "
            SELECT 
                a.c_code,
                e.c_rs,
                a.ca_code,
                c.tcarte_lib,
                a.ca_champ_1,
                a.ca_champ_2,
                a.ca_champ_3,
                a.ca_valid,
                a.ca_ln,
                d.rln_lib,
                b.clas_lib,
                a.ca_statut,
                a.ca_immatriculation,
                a.ca_immat_peage_autorise
            FROM 
                carte AS a
            LEFT OUTER JOIN raison_ln AS d ON a.rln_code = d.rln_code
            JOIN classe b ON a.clas_code = b.clas_code
            JOIN type_carte c ON a.tcarte_code = c.tcarte_code
            JOIN client e ON a.c_code = e.c_code
            AND UPPER(REPLACE(REPLACE(a.ca_immatriculation, '-', ''), ' ', '')) LIKE 
                UPPER(REPLACE(REPLACE(:plaque, '-', ''), ' ', ''))";
        if($activite) {
            $sql .= " AND a.ca_valid = 1";
        }

        $sql .= " ORDER BY a.c_code DESC";


        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':plaque', "%$plaque%", PDO::PARAM_STR);
        $stmt->execute();

        return  $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    /**
     * Recherche les cartes d’un client avec filtre sur les champs libres
     */
    public function searchCartesByLibres(string $libre,bool $activite =false): array {
        $sql = "
            SELECT 
                a.c_code,
                e.c_rs,
                a.ca_code,
                c.tcarte_lib,
                a.ca_champ_1,
                a.ca_champ_2,
                a.ca_champ_3,
                a.ca_valid,
                a.ca_ln,
                d.rln_lib,
                b.clas_lib,
                a.ca_statut,
                a.ca_immatriculation,
                a.ca_immat_peage_autorise,
                f.rci_lib 
            FROM 
                carte AS a
            LEFT OUTER JOIN raison_ln AS d ON a.rln_code = d.rln_code
            JOIN classe b ON a.clas_code = b.clas_code
            JOIN type_carte c ON a.tcarte_code = c.tcarte_code
            JOIN client e ON a.c_code = e.c_code
            LEFT JOIN RAISON_CARTE_INACTIVE f ON a.RCI_CODE = f.RCI_CODE
            WHERE 
                (a.ca_champ_1 LIKE :libre1
                OR a.ca_champ_2 LIKE :libre2
                OR a.ca_champ_3 LIKE :libre3)";


        if($activite) {
        $sql .= " AND a.ca_valid = 1";
    }

    $sql .= " ORDER BY a.c_code DESC";


        $stmt = $this->db->prepare($sql);
        $like = '%' . $libre . '%';
        $stmt->bindValue(':libre1', $like, PDO::PARAM_STR);
        $stmt->bindValue(':libre2', $like, PDO::PARAM_STR);
        $stmt->bindValue(':libre3', $like, PDO::PARAM_STR);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère le détail pour une carte donnée
     */
        public function getCarteDetail(string $c_code, string $ca_code): array {
                $sql = "
        SELECT 
            a.c_code, 
            a.ca_code, 
            c.tcarte_lib,
            a.ca_champ_1,
            a.ca_champ_2,
            a.ca_champ_3,
            a.ca_valid,
            a.ca_ln,
            d.rln_lib,
            b.clas_lib,
            CONVERT(char(10), a.ca_date_valid, 103) AS ca_date_valid,
            a.ca_nbre_passage,
            a.ca_immatriculation,
            a.ca_immat_peage_autorise,
            a.ca_statut,
            a.tcarte_code 
        FROM 
            carte AS a
        LEFT JOIN raison_ln AS d ON a.rln_code = d.rln_code
        JOIN classe AS b ON a.clas_code = b.clas_code
        JOIN type_carte AS c ON a.tcarte_code = c.tcarte_code
        WHERE 
            a.C_CODE = :c_code
            AND a.ca_code = :ca_code
    ";

                $stmt = $this->db->prepare($sql);
                $stmt->bindValue(':c_code', $c_code, PDO::PARAM_STR);
                $stmt->bindValue(':ca_code', $ca_code, PDO::PARAM_STR);
                $stmt->execute();


                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                return $result ? [$result] : [];
            }








    /**
     * Récupère les passages pour une carte donnée
     */
    public function getPassagesCarteDetail(string $c_code, string $ca_code): array {
        $sql = "SELECT TOP(13) 
                    hpc_date, 
                    CONVERT(char(10), hpc_date, 103) AS date,   -- Format: dd/mm/yyyy
                    CONVERT(char(8), hpc_date, 108) AS heure,   -- Format: hh:mm:ss
                    voie_num, 
                    gare_num, 
                    clasdect, 
                    HPC_SOLDE_PTS  
                FROM 
                    AboBackup1.dbo.histo_pass_carte_annee_cour
                WHERE 
                    C_CODE = :c_code
                    AND ca_code = :ca_code
                ORDER BY 
                    hpc_date DESC; 
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':c_code', $c_code, PDO::PARAM_STR);
        $stmt->bindValue(':ca_code', $ca_code, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    /**
     * Récupère les alertes SMS pour une carte donnée
     */
    public function getSMSCarteDetail(string $c_code, string $ca_code): array {
        $sql = "SELECT TOP(5) wa_date_creation,
                    CONVERT(char(10), wa_date_creation, 103) AS date,   -- Format: dd/mm/yyyy
                    CONVERT(char(5), wa_date_creation, 108) AS heure,   -- Format: hh:mm
                    wa_lib_court
                FROM 
                    web_alerte
                WHERE 
                    C_CODE =:c_code 
                    AND wtsa_code = 4 
                    AND SUBSTRING(wa_lib_long, 7, 3) = :ca_code 
                ORDER BY 
                    wa_code DESC;
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':c_code', $c_code, PDO::PARAM_STR);
        $stmt->bindValue(':ca_code', $ca_code, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getHistoriqueCarteDetail(string $c_code, string $ca_code): array {
//        var_dump($c_code, $ca_code);
        $sql = "SELECT 
                    CONVERT(char(13), hc_date, 103) AS date,
                    CONVERT(char(8), hc_date, 108) AS heure,
                    ta_lib,
                    hc_cplt,
                    hc_nb_pts,
                    AGENT_ID,
                    a.ta_code
                FROM 
                    histo_carte a
                JOIN 
                    type_action b ON a.ta_code = b.ta_code
                WHERE 
                    TA_VISIBLE_WEB = 1
                    AND C_CODE = :c_code
                    AND CA_CODE = :ca_code
                ORDER BY 
                    hc_date DESC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':c_code', $c_code, PDO::PARAM_STR);
        $stmt->bindValue(':ca_code', $ca_code, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getHistoriqueMoisCarteDetail(string $c_code, string $ca_code): array {
        $sql = "SELECT 
    CASE MONTH(hpc_date)
        WHEN 1 THEN 'Janvier'
        WHEN 2 THEN 'Février'
        WHEN 3 THEN 'Mars'
        WHEN 4 THEN 'Avril'
        WHEN 5 THEN 'Mai'
        WHEN 6 THEN 'Juin'
        WHEN 7 THEN 'Juillet'
        WHEN 8 THEN 'Août'
        WHEN 9 THEN 'Septembre'
        WHEN 10 THEN 'Octobre'
        WHEN 11 THEN 'Novembre'
        WHEN 12 THEN 'Décembre'
    END AS mois_fr,
    YEAR(hpc_date) AS an,
    COUNT(CASE WHEN HPC_SOLDE_PTS <> 992 THEN 1 ELSE NULL END) AS pass_cartes,
    COUNT(CASE WHEN HPC_SOLDE_PTS = 992 THEN 1 ELSE NULL END) AS pass_Autorisation
FROM AboRungis.dbo.histo_pass_carte a
WHERE C_CODE = :c_code
AND ca_code = :ca_code
AND hpc_date >= DATEADD(MONTH, -12, GETDATE())
GROUP BY 
    MONTH(hpc_date),
    YEAR(hpc_date)
ORDER BY 
    YEAR(hpc_date) DESC,
    MONTH(hpc_date) DESC";




        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':c_code', $c_code, PDO::PARAM_STR);
        $stmt->bindValue(':ca_code', $ca_code, PDO::PARAM_STR);
        $stmt->execute();


        $resultat = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $resultat;

    }
}

