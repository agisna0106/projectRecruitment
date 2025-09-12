<?php
include 'header.php';
require_once '../controller/kopiKontroller.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 3) {
    header("Location: dashboard.php");
    exit;
}

if (isset($_POST['submit'])) {
    $kopi = new kopiKontroller();
    $kopi->insert();
}
?>
<section class="body_tambah_kopi">
    <form action="" method="post" enctype="multipart/form-data">
        <div class="card-tambah-update">
            <label for="nama_kopi">Nama Kopi : </label>
            <input type="text" name="nama_kopi" id="nama_kopi">
            <label for="harga">Harga Jual : </label>
            <input type="number" name="harga" id="harga" required>
            <label for="foto">Foto Kopi : </label>
           <div class="container-input-foto">
                <input type="file" name="foto" id="foto" accept="image/*" hidden/>

                <!-- our custom upload button -->
                <label for="foto" class="label-input-file">Choose File</label>

                <!-- name of file chosen -->
                <span id="file-chosen">No file chosen</span>
           </div>
            <button type="submit" name="submit">Tambah</button>
        </div>
    </form>

</section>
<script>
    const actualBtn = document.getElementById('foto');

    const fileChosen = document.getElementById('file-chosen');

    actualBtn.addEventListener('change', function(){
    fileChosen.textContent = this.files[0].name
    console.log(fileChosen);
    
    })
</script>
</body>

</html>