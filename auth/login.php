<?php

require_once '../model/Database.php';

class Login {
    public $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function login() 
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $get_password = "SELECT username, password FROM user WHERE username='$username'";
        $result = $this->db->mysqli->prepare($get_password);
        if($result == null) {
            header("Location: loginForm.php");
            exit;
        }
        if($username == $get_password['username'] AND $password == $get_password['password']) {
            header("Location: ../view/kopi.php");
            exit;
        } else {
            header("Location: loginForm.php");
            exit;
        }
    }
}