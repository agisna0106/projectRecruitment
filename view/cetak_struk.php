<?php
require_once '../model/Database.php';
$db = new Database();
$conn = $db->mysqli;

$transaksi_id = $_GET['id'] ?? 0;

$stmt = $conn->prepare("SELECT t.*, u.name AS kasir 
    FROM transaksi t
    JOIN users u ON u.id = t.kasir_id
    WHERE t.id = ?");
$stmt->bind_param("i", $transaksi_id);
$stmt->execute();
$transaksi = $stmt->get_result()->fetch_assoc();
$stmt->close();

$stmt = $conn->prepare("SELECT d.*, k.nama_kopi AS produk_nama, k.harga 
    FROM detail_transaksi d
    JOIN kopi k ON k.id_kopi = d.produk_id
    WHERE d.transaksi_id = ?");
$stmt->bind_param("i", $transaksi_id);
$stmt->execute();
$details = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

if (!$transaksi) {
    echo "<h2>❌ Transaksi tidak ditemukan!</h2>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Struk Transaksi #<?= $transaksi_id ?></title>
    <style>
        body { font-family: monospace; padding: 20px; }
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        td, th { padding: 6px; border-bottom: 1px solid #ddd; }
        .total { font-weight: bold; }
    </style>
</head>
<body>
    <h2>Struk Kopiku</h2>
    <p>No Transaksi: <?= $transaksi['id'] ?></p>
    <p>Tanggal: <?= $transaksi['tanggal'] ?></p>
    <p>Kasir: <?= $transaksi['kasir'] ?></p>

    <table>
        <thead>
            <tr>
                <th>Produk</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($details as $d): ?>
            <tr>
                <td><?= $d['produk_nama'] ?></td>
                <td><?= $d['jumlah'] ?></td>
                <td>Rp<?= number_format($d['harga']) ?></td>
                <td>Rp<?= number_format($d['subtotal']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <p class="total" style="text-align:right;">Total: Rp<?= number_format($transaksi['total']) ?></p>
    <p style="text-align:center;">Terima kasih ☕</p>
    <p style="text-align: center;">
    <a href="transaksi.php">
        <button style="padding: 10px 20px; background-color: #C97C5D; color: white; border: none; border-radius: 5px; cursor: pointer;">
            ⬅ Kembali ke Transaksi
        </button>
    </a>
</p>
</body>
</html>
