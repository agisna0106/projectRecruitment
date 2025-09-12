<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 3) {
    header("Location: dashboard.php");
    exit;
}
require_once '../model/Database.php';

$db = new Database();
$conn = $db->mysqli;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    // Cek username sudah digunakan
    $check = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $check->bind_param("s", $username);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "<script>alert('Username sudah digunakan!'); window.location.href='users.php';</script>";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (name, username, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nama, $username, $password, $role);
        if ($stmt->execute()) {
            echo "<script>alert('User berhasil ditambahkan'); window.location.href='users.php';</script>";
        } else {
            echo "<script>alert('Gagal menyimpan user'); window.location.href='users.php';</script>";
        }
        $stmt->close();
    }

    $check->close();
}
?>
