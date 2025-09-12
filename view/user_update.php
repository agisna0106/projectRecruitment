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
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $role = $_POST['role'];

    $stmt = $conn->prepare("UPDATE users SET name = ?, username = ?, role = ? WHERE id = ?");
    $stmt->bind_param("sssi", $nama, $username, $role, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: users.php");
    exit;
}
