<?php

class Ticket {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    /**
     * Récupère les cartes d'un client par son code
     */
    public function searchPassExpressByClient(string $c_code): array {

        $sql = "SELECT ID,C_CODE,convert(char(16), DATE_START_VALID,103) as DATE_START_VALID, DATE_END_VALID, convert(char(10), DATE_USED,103) as DATE_USED,
						convert(char(5), DATE_USED,108) as DATE_USED_HEURE
						FROM BARCODES where type_of_card = 12	
						and datediff(dd, DATE_END_VALID, getdate()) < 730
						and C_CODE = :c_code order by DATE_START_VALID desc
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':c_code', $c_code, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}