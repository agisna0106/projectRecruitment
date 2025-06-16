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
               <div>
                 <h1><?= "$data[nama_kopi]" ?></h1>
               </div>
                <p>Rp. <?= "$data[harga]" ?></p>
                <div class="btn-edit-delete">
                    <a href="editKopi.php?id_kopi=<?= $data['id_kopi'] ?>"><button class="btn-edit">Edit</button></a>
                    <form action="" method="post" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                        <input type="hidden" name="id_kopi" value="<?= "$data[id_kopi]" ?>">
                        <button class="btn-delete" name="delete">Hapus</button>
                    </form>
                    <?php
                        if(isset($_POST['delete'])) {
                            $kopi->delete($_POST['id_kopi']);
                            header("Location: ../view/kopi.php");
                            exit;
                        }
                    ?>
                </div>
            </div>
        <?php endforeach ?>
    </div>

</section>
<footer></footer>
</body>

</html>