<?php

require_once '../model/Database.php';

class usersController {
    public $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function select($role = null)
    {
        if ($role !== null) {
            $stmt = $this->db->mysqli->prepare("SELECT * FROM users WHERE role = ?");
            $stmt->bind_param("i", $role);
        } else {
            $stmt = $this->db->mysqli->prepare("SELECT * FROM users");
        }

        $stmt->execute();
        $result = $stmt->get_result();

        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }
}