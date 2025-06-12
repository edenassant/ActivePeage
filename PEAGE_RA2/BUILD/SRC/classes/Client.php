<?php

class Client {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    /**
     * Récupère les cartes d'un client par son code
     */
    public function searchClientsByRaisonSociale(string $nom): array {

        $sql = "SELECT distinct a.c_code, 
                c_rs, 
                c_enseigne, 
                c_statut, 
                a_lib, 
                cat_lib, 
                convert(char(10),c_date_fin_validite,103) as c_date_fin_validite, 
                c_cp_f, 
                c_commune_f,
		        cor_nom + ' ' + cor_prenom as nom_corres 
                from client a 
				left outer join correspondant d on a.c_code = d.c_code, 
                cat b , 
                activite c 
				where a.cat_code = b.cat_code
				and	a.a_code = c.a_code 
				and 	( c_rs like :nom1 or c_enseigne like :nom2 or COR_nom like :nom3) order by c_rs asc
        ";

        $stmt = $this->db->prepare($sql);
        $like = '%' . $nom . '%';
        $stmt->bindValue(':nom1', $like, PDO::PARAM_STR);
        $stmt->bindValue(':nom2', $like, PDO::PARAM_STR);
        $stmt->bindValue(':nom3', $like, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }





    public function getClientInfo(string $c_code) {
        $sql = "SELECT 
    c.c_code, 
    c.c_rs, 
    c.c_statut, 
    c.C_EMAIL,
    c.C_TEL,
    i.a_lib, 
    h.cat_lib, 
    c.cat_code, 
    CONVERT(char(10), c.c_date_fin_validite, 103) AS c_date_fin_validite,
    CONVERT(char(10), c.c_date_cloture, 103) AS c_date_cloture,
    c.c_alertesms, 
    c.c_tel,
    LTRIM(
        ISNULL(c.C_NOM_VOIE_F + ' ', '') +
        ISNULL(c.C_CPLT_VOIE_F + ' ', '') +
        ISNULL(c.C_CPLT_VOIE2_F + ' ', '') +
        ISNULL(c.C_CPLT_VOIE3_F + ' ', '') +
        ISNULL(c.c_cp_f + ' ', '') +
        ISNULL(c.c_commune_f + ' ', '') +
        ISNULL(g.PAYS_LIB, '')
    ) AS AdresseF
FROM CLIENT c  
LEFT JOIN PAYS g ON g.pays_CODE = c.pays_CODE_F
INNER JOIN cat h ON c.cat_code = h.cat_code
INNER JOIN activite i ON c.a_code = i.a_code 
WHERE c.C_CODE =
:c_code
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':c_code', $c_code, PDO::PARAM_STR);
        $stmt->execute();

        $result1 =$stmt->fetch(PDO::FETCH_ASSOC);
        return $result1 ?: null;

    }

    
}