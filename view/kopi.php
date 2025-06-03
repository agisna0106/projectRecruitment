<?php
include 'header.php';
require_once '../controller/kopiKontroller.php';

$kopi = new kopiKontroller();

$datas = $kopi->select();
?>
<section class="body">
    <div class="action-bar">
        <a href="tambahKopi.php"><button class="btn-add">+ Tambah Kopi</button></a>
    </div>
    <div class="kopi-container">
        <?php
        foreach ($datas as $data):
        ?>
            <div class="kopi-card">
                <img class="kopi-image" src="../assets/<?= "$data[foto]" ?>" alt="">
                <p><?= "$data[nama_kopi]" ?></p>
                <p><?= "$data[harga]" ?></p>
                <div class="btn-edit-delete">
                    <button class="btn-edit">Edit</button>
                    <button class="btn-delete">Hapus</button>
                </div>
            </div>
        <?php endforeach ?>
    </div>

</section>
<footer></footer>
</body>

</html>