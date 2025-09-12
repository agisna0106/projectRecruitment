<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 2) {
    header("Location: dashboard.php");
    exit;
}

require_once '../model/Database.php';

$loggedIn = isset($_SESSION['user']);

$db = new Database();
$conn = $db->mysqli;
$kopis = $conn->query("SELECT * FROM kopi")->fetch_all(MYSQLI_ASSOC);
$kasir_id = $_SESSION['user']['id'] ?? 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Transaksi Kasir</title>
  <style>
    body { background-color: #f5e9da; font-family: Arial; padding: 20px; }
    h2 { text-align: center; color: #5a3825; }
    .container { display: flex; gap: 30px; }
    .produk-list {
      flex: 2;
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
      gap: 20px;
    }
    .produk {
      background: #fff; padding: 10px;
      border-radius: 10px; text-align: center;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .produk img {
      width: 100%; height: 150px; object-fit: cover; border-radius: 8px;
    }
    .produk h4 { margin: 10px 0 5px; color: #5a3825; }
    .produk button {
      background-color: #C97C5D; color: white; border: none;
      padding: 6px 12px; border-radius: 5px; cursor: pointer;
    }
    .keranjang {
      flex: 1; background: #fff; padding: 20px;
      border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .keranjang h3 { margin-top: 0; color: #5a3825; }
    .keranjang ul { list-style: none; padding: 0; }
    .keranjang li { margin-bottom: 8px; }
    .keranjang button {
      width: 100%; margin-top: 10px;
      padding: 10px; border: none; border-radius: 5px; color: white;
    }
    .btn-bayar { background-color: #C97C5D; }
    .btn-reset { background-color: #999; }
    .total { margin-top: 10px; font-weight: bold; }
    .logout-container {
        display: flex;
        justify-content: flex-end;
    }
    .btn-logout {
        background-color: brown;
        color: #fff;
        border: none;
        border-radius: 5px;
        padding: 5px 8px;
    }
  </style>
</head>
<body>
<div class="logout-container">
<?php if ($loggedIn): ?>
    <form action="../auth/logout.php" method="POST" style="display:inline;">
        <button type="submit" class="btn-logout">Logout</button>
    </form>
<?php endif ?>
</div>

<h2>Transaksi Penjualan Kopi</h2>

<div class="container">
  <!-- Produk -->
  <div class="produk-list">
    <?php foreach ($kopis as $kopi): ?>
    <div class="produk">
      <img src="../assets/<?= $kopi['foto'] ?>" onerror="this.src='../assets/default.jpg'">
      <h4><?= $kopi['nama_kopi'] ?></h4>
      <p>Rp<?= number_format($kopi['harga']) ?></p>
      <input style="margin-bottom: 1vh;" type="number" id="qty-<?= $kopi['id_kopi'] ?>" value="1" min="1">
      <button onclick="tambah(<?= $kopi['id_kopi'] ?>, '<?= $kopi['nama_kopi'] ?>', <?= $kopi['harga'] ?>)">Beli</button>
    </div>
    <?php endforeach; ?>
  </div>

  <!-- Keranjang -->
  <div class="keranjang">
    <h3>Keranjang</h3>
    <ul id="list-keranjang"></ul>
    <div class="total">Total: Rp<span id="total">0</span></div>
    <button class="btn-bayar" onclick="simpanTransaksi()">Bayar</button>
    <button class="btn-reset" onclick="resetKeranjang()">Reset</button>
  </div>
</div>

<script>
let keranjang = [];

function tambah(id, nama, harga) {
  const qty = parseInt(document.getElementById('qty-' + id).value) || 1;
  const existing = keranjang.find(item => item.id === id);
  if (existing) {
    existing.jumlah += qty;
    existing.subtotal = existing.jumlah * harga;
  } else {
    keranjang.push({ id, nama, harga, jumlah: qty, subtotal: harga * qty });
  }
  render();
}

function render() {
  const ul = document.getElementById('list-keranjang');
  ul.innerHTML = '';
  let total = 0;
  keranjang.forEach(item => {
    total += item.subtotal;
    const li = document.createElement('li');
    li.textContent = `${item.nama} x ${item.jumlah} = Rp${item.subtotal.toLocaleString()}`;
    ul.appendChild(li);
  });
  document.getElementById('total').textContent = total.toLocaleString();
}

function resetKeranjang() {
  keranjang = [];
  render();
}

function simpanTransaksi() {
  if (keranjang.length === 0) {
    alert('Keranjang masih kosong!');
    return;
  }

  const total = keranjang.reduce((sum, item) => sum + item.subtotal, 0);

  fetch('proses_transaksi.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ items: keranjang, total })
  })
  .then(res => res.json())
  .then(res => {
    if (res.success) {
      alert('Transaksi berhasil!');
      window.location.href = `cetak_struk.php?id=${res.transaksi_id}`;
    } else {
      alert('Gagal menyimpan transaksi!');
    }
  })
  .catch(err => {
    console.error(err);
    alert('Terjadi kesalahan koneksi.');
  });
}
</script>

</body>
</html>
