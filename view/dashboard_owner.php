<?php
require_once '../model/Database.php';
include 'header.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 3) {
    header('Location: login.php');
    exit;
}

$db = new Database();
$conn = $db->mysqli;

$filter_sql = "";

if (isset($_GET['tanggal']) && $_GET['tanggal'] != '') {
    $tgl = $_GET['tanggal'];
    $filter_sql = "AND DATE(tanggal) = '$tgl'";
} elseif (isset($_GET['filter']) && $_GET['filter'] != '') {
    if ($_GET['filter'] === 'today') {
        $filter_sql = "AND DATE(tanggal) = CURDATE()";
    } elseif ($_GET['filter'] === 'this_week') {
        $filter_sql = "AND YEARWEEK(tanggal, 1) = YEARWEEK(CURDATE(), 1)";
    } elseif ($_GET['filter'] === 'this_month') {
        $filter_sql = "AND MONTH(tanggal) = MONTH(CURDATE()) AND YEAR(tanggal) = YEAR(CURDATE())";
    }
}


$query = "
    SELECT t.id, t.tanggal, t.total, u.name AS kasir 
    FROM transaksi t 
    LEFT JOIN users u ON u.id = t.kasir_id 
    WHERE 1 $filter_sql 
    ORDER BY t.tanggal DESC
";
$result = $conn->query($query);
$transaksis = $result->fetch_all(MYSQLI_ASSOC);

// Hitung total pemasukan
$total_pemasukan = array_sum(array_column($transaksis, 'total'));
?>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body { font-family: Arial; background-color: #fff; padding: 0; }
        .content { padding: 30px; }
        h2 { color: #5a3825; }
        table {
            width: 100%; border-collapse: collapse; background: #fff;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 10px; border-bottom: 1px solid #eee; text-align: center;
        }
        th { background-color: #C97C5D; color: white; }
        .total-box {
            margin-top: 20px; font-weight: bold; font-size: 18px;
            color: #fff; background: #C97C5D; padding: 10px 15px;
            display: inline-block; border-radius: 8px;
        }
    </style>
</head>
<body>

<section class="content">
<h2>Laporan Penjualan</h2>

<form method="GET" style="margin-bottom: 20px;">
    <select name="filter" onchange="this.form.submit()">
        <option value="">-- Semua --</option>
        <option value="today" <?= ($_GET['filter'] ?? '') === 'today' ? 'selected' : '' ?>>Hari ini</option>
        <option value="this_week" <?= ($_GET['filter'] ?? '') === 'this_week' ? 'selected' : '' ?>>Minggu ini</option>
        <option value="this_month" <?= ($_GET['filter'] ?? '') === 'this_month' ? 'selected' : '' ?>>Bulan ini</option>
    </select>
    &nbsp; atau pilih tanggal: 
    <input type="date" name="tanggal" value="<?= $_GET['tanggal'] ?? '' ?>" onchange="this.form.submit()">
</form>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Kasir</th>
            <th>Total Transaksi</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; foreach ($transaksis as $t): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= date('d M Y H:i', strtotime($t['tanggal'])) ?></td>
            <td><?= $t['kasir'] ?: '-' ?></td>
            <td>Rp<?= number_format($t['total'], 0, ',', '.') ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="total-box">
    Total Pemasukan: Rp<?= number_format($total_pemasukan, 0, ',', '.') ?>
</div>

</body>
</html>
</section>

