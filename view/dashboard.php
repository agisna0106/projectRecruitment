<?php 
require_once '../controller/kopiKontroller.php';
include 'header.php';

$kopi = new kopiKontroller();

$datas = $kopi->select();
?>

    <section class="body">
        <div class="kopi-container">
            <?php
            foreach ($datas as $data) :
            ?>
                <div class="kopi-card">
                    <img class="kopi-image" src="../assets/<?= $data['foto'] ?>" alt="">
                    <p><?= $data['nama_kopi'] ?></p>
                </div>
            <?php endforeach?>
        </div>
        
    </section>
    <footer></footer>
</body>
</html>