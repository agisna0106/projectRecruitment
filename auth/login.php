<?php
session_start();

require_once '../model/Database.php';

class Login {
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->mysqli;
    }

    public function login() 
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $stmt = $this->conn->prepare("SELECT id, name, username, password, role FROM users WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if($result->num_rows === 1) {
                $user = $result->fetch_assoc();

                if(password_verify($password, $user['password'])) {
                    $_SESSION['user'] = [
                        'id' => $user['id'],
                        'name' => $user['name'],
                        'role' => $user['role']
                    ];
                    if ($user) {
                        $_SESSION['user'] = $user;

                        if ($user['role'] == 2) {
                            header("Location: ../view/transaksi.php"); 
                        } else {
                            header("Location: ../view/dashboard.php"); 
                        }
                        exit;
                    }
                    header("Location: ../view/dashboard.php");
                    exit;
                } else {
                    $_SESSION['error'] = "Password salah!";
                    header("Location: loginForm.php");
                    exit;
                }

                $stmt->close();
            }
        }
    }
}
