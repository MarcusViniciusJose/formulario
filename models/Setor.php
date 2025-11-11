<?php
require_once __DIR__ . '/../core/Database.php';

class Setor {
    private $db;

    public function __construct() {
        $this->db = Database::conn();
    }

    public function listar() {
        $stmt = $this->db->query("SELECT * FROM setores ORDER BY nome ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
