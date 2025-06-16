<?php
include 'header.php';

require_once '../controller/kopiKontroller.php';

$kopi = new kopiKontroller();
$datas = $kopi->getAllData($_GET['id_kopi']);

if (isset($_POST['submit'])) {
    if(!empty($_FILES['foto']['name'])) {
        $kopi->updateNPhoto();
    } else {
        $kopi->update();
    }
    
}
?>
<section class="body_tambah_kopi">
    <?php foreach ($datas as $data) : ?>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="card-tambah-update">
            <input type="hidden" name="id_kopi" value="<?= $data['id_kopi'] ?>">
            <label for="nama_kopi">Nama Kopi : </label>
            <input type="text" name="nama_kopi" id="nama_kopi" value="<?= $data['nama_kopi'] ?>" required>
            <label for="harga">Harga Jual : </label>
            <div>
                Rp.<input type="number" name="harga" id="harga" value="<?= $data['harga'] ?>" required>
            </div>
            <label for="foto">Foto Kopi : </label>
            <input type="file" name="foto" id="foto" accept="image/*" >
            <button type="submit" name="submit">Tambah</button>
        </div>
    </form>
    <?php endforeach ?>

</section>
</body>

</html>