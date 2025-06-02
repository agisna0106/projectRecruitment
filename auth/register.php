<?php
include_once '../model/Database.php';

class Register {
    public $db;
    
    public function __construct()
    {
        $this->db = new Database();
    }

    public function register() {
        $name = $_POST['name'];
        $username = $_POST['username'];
        $pass = $_POST['password'];
        $role = 1;

        if(empty($name) || empty($username) || empty($pass)) {
            echo "<script>alert('Nama, Username atau Password tidak boleh kosong!');
            window.location.href = 'registerForm.php'; </script>";
            exit();
        } else {
            $get_user = "SELECT * FROM users WHERE username = '$username'";
            $result = $this->db->mysqli->query($get_user);
            $check_username = $result->num_rows;

            if($check_username > 0) {
                echo '<script>alert("Username sudah terpakai");</script>';
            } else {
                $passwordHash = password_hash($pass, PASSWORD_DEFAULT);
                $sql = "INSERT INTO users (name, username, password, role) VALUES ('".$name."', '".$username."', '".$passwordHash."', '".$role."')";

                $result = $this->db->mysqli->query($sql);

                if($result) {
                    echo "<script>window.location.href='loginForm.php';alert('Register Berhasil');</script>";
                } else {
                    echo "<script>alert('Register Gagal');</script>";
                }
            }
        }

    }
}