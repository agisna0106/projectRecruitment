<?php
session_start();
include '../assets/tcpdf/tcpdf.php';
require_once '../model/Database.php';
$db = new Database();
$conn = $db->mysqli;

// PRG Pattern - proses submit dulu, lalu redirect
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tambah_pengeluaran'])) {
    $keterangan = $_POST['keterangan'];
    $jumlah = $_POST['jumlah'];
    $tanggal = $_POST['tanggal'];
    $user_id = $_SESSION['user']['id'];

    $stmt = $conn->prepare("INSERT INTO pengeluaran (user_id, deskripsi, jumlah, tanggal) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isis", $user_id, $keterangan, $jumlah, $tanggal);
    $stmt->execute();
    $stmt->close();

    header("Location: keuangan.php"); // Redirect untuk mencegah form resubmit
    exit;
}

// Filter tanggal
$filter = $_GET['filter'] ?? 'all';
$start_date = '';
$end_date = '';

switch ($filter) {
    case 'today':
        $start_date = date('Y-m-d');
        $end_date = date('Y-m-d');
        break;
    case 'week':
        $start_date = date('Y-m-d', strtotime('-7 days'));
        $end_date = date('Y-m-d');
        break;
    case 'month':
        $start_date = date('Y-m-01');
        $end_date = date('Y-m-t');
        break;
    case 'custom':
        $start_date = $_GET['start_date'] ?? '';
        $end_date = $_GET['end_date'] ?? '';
        break;
    default:
        $start_date = '1970-01-01';
        $end_date = date('Y-m-d');
}

// Query pendapatan
$sqlPendapatan = "SELECT * FROM transaksi WHERE DATE(tanggal) BETWEEN ? AND ?";
$stmt = $conn->prepare($sqlPendapatan);
$stmt->bind_param("ss", $start_date, $end_date);
$stmt->execute();
$pendapatanData = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Query pengeluaran
$sqlPengeluaran = "SELECT p.*, u.name as nama_user FROM pengeluaran p 
                   JOIN users u ON p.user_id = u.id
                   WHERE DATE(p.tanggal) BETWEEN ? AND ?";
$stmt = $conn->prepare($sqlPengeluaran);
$stmt->bind_param("ss", $start_date, $end_date);
$stmt->execute();
$pengeluaranData = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Hitung total
$totalPendapatan = array_sum(array_column($pendapatanData, 'total'));
$totalPengeluaran = array_sum(array_column($pengeluaranData, 'jumlah'));
$saldoAkhir = $totalPendapatan - $totalPengeluaran;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pengelolaan Keuangan</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #FFF8F0; }
        h1 { text-align: center; color: #6B4226; }
        .container { max-width: 1000px; margin: auto; }
        .form-section, .filter-section {
            background: #f9f9f9; padding: 15px; border-radius: 10px; margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        input, select, button {
            padding: 8px; border-radius: 5px; border: 1px solid #bbb;
        }
        button {
            background: #C97C5D; color: white; border: none; cursor: pointer;
        }
        button:hover { background: #a8684e; }
        table { width: 100%; border-collapse: collapse; background: white; }
        th, td { padding: 10px; border: 1px solid #eee; }
        th { background: #C97C5D; color: white; }
        .ringkasan { margin-top: 20px; padding: 15px; background: #f1f1f1; border-radius: 10px; }
        .btn-edit { background: #FFC107; }
        .btn-delete { background: #E74C3C; }
        .btn-edit:hover { background: #e0a800; }
        .btn-delete:hover { background: #c0392b; }
    </style>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<h1>Pengelolaan Keuangan</h1>

<!-- Form Filter -->
<form method="GET">
    <select name="filter" onchange="this.form.submit()">
        <option value="all" <?= $filter == 'all' ? 'selected' : '' ?>>Semua</option>
        <option value="today" <?= $filter == 'today' ? 'selected' : '' ?>>Hari Ini</option>
        <option value="week" <?= $filter == 'week' ? 'selected' : '' ?>>Minggu Ini</option>
        <option value="month" <?= $filter == 'month' ? 'selected' : '' ?>>Bulan Ini</option>
        <option value="custom" <?= $filter == 'custom' ? 'selected' : '' ?>>Custom</option>
    </select>
    <?php if ($filter == 'custom'): ?>
        <input type="date" name="start_date" value="<?= $start_date ?>">
        <input type="date" name="end_date" value="<?= $end_date ?>">
        <button type="submit">Terapkan</button>
    <?php endif; ?>
</form>

<!-- Form Input Pengeluaran -->
<h2>Tambah Pengeluaran</h2>
<form method="POST">
    <input type="text" name="keterangan" placeholder="Keterangan" required>
    <input type="number" name="jumlah" placeholder="Jumlah" required>
    <input type="date" name="tanggal" value="<?= date('Y-m-d') ?>" required>
    <button type="submit" name="tambah_pengeluaran">Simpan</button>
</form>

<!-- Tabel Pendapatan -->
<h2>Pendapatan</h2>
<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>Tanggal</th>
        <th>Total Harga</th>
    </tr>
    <?php foreach ($pendapatanData as $row): ?>
        <tr>
            <td><?= $row['tanggal'] ?></td>
            <td>Rp<?= number_format($row['total'], 0, ',', '.') ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<!-- Tabel Pengeluaran -->
<h2>Pengeluaran</h2>
<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>Tanggal</th>
        <th>Keterangan</th>
        <th>Jumlah</th>
        <th>Penginput</th>
    </tr>
    <?php foreach ($pengeluaranData as $row): ?>
        <tr>
            <td><?= $row['tanggal'] ?></td>
            <td><?= $row['deskripsi'] ?></td>
            <td>Rp<?= number_format($row['jumlah'], 0, ',', '.') ?></td>
            <td><?= $row['nama_user'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<!-- Ringkasan -->
<h2>Ringkasan</h2>
<p>Total Pendapatan: <strong>Rp<?= number_format($totalPendapatan, 0, ',', '.') ?></strong></p>
<p>Total Pengeluaran: <strong>Rp<?= number_format($totalPengeluaran, 0, ',', '.') ?></strong></p>
<p>Saldo Akhir: <strong>Rp<?= number_format($saldoAkhir, 0, ',', '.') ?></strong></p>

<!-- Export PDF -->
<form method="GET" action="export_keuangan.php" target="_blank">
    <input type="hidden" name="filter" value="<?= $filter ?>">
    <input type="hidden" name="start_date" value="<?= $start_date ?>">
    <input type="hidden" name="end_date" value="<?= $end_date ?>">
    <button type="submit">Export PDF</button>
</form>

</body>
</html>
