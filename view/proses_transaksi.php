<?php
session_start();
require_once '../model/Database.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 2) {
    header("Location: dashboard.php");
    exit;
}

$db = new Database();
$conn = $db->mysqli;

// Ambil data POST
$data = json_decode(file_get_contents('php://input'), true);

if (!$data || empty($data['items'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Data transaksi tidak valid']);
    exit;
}

$items = $data['items'];
$total = $data['total'];
$kasir_id = $_SESSION['user']['id'] ?? 0;

// Simpan transaksi
$stmt = $conn->prepare("INSERT INTO transaksi (tanggal, total, kasir_id) VALUES (NOW(), ?, ?)");
$stmt->bind_param("di", $total, $kasir_id);
$stmt->execute();
$transaksi_id = $stmt->insert_id;
$stmt->close();

// Simpan detail transaksi
$stmt_detail = $conn->prepare("INSERT INTO detail_transaksi (transaksi_id, produk_id, jumlah, subtotal) VALUES (?, ?, ?, ?)");

foreach ($items as $item) {
    $produk_id = $item['id'];
    $jumlah = $item['jumlah'];
    $subtotal = $item['harga'] * $jumlah;
    $stmt_detail->bind_param("iiid", $transaksi_id, $produk_id, $jumlah, $subtotal);
    $stmt_detail->execute();
}
$stmt_detail->close();

echo json_encode([
    'success' => true,
    'message' => 'Transaksi berhasil disimpan',
    'transaksi_id' => $transaksi_id
]);
