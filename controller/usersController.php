<?php

require_once '../model/Database.php';

class usersController {
    public $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function select()
    {
        $sql = "SELECT * FROM users";
        $result = $this->db->mysqli->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}