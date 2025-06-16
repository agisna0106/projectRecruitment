<?php
include 'header.php';
require_once '../controller/kopiKontroller.php';

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
            <div>
                Rp.<input type="number" name="harga" id="harga" required>
            </div>
            <label for="foto">Foto Kopi : </label>
           <div class="container-input-foto">
                <input type="file" id="actual-btn" hidden/>

                <!-- our custom upload button -->
                <label for="actual-btn" class="label-input-file">Choose File</label>

                <!-- name of file chosen -->
                <span id="file-chosen">No file chosen</span>
           </div>
            <button type="submit" name="submit">Tambah</button>
        </div>
    </form>

</section>
<script>
    const actualBtn = document.getElementById('actual-btn');

    const fileChosen = document.getElementById('file-chosen');

    actualBtn.addEventListener('change', function(){
    fileChosen.textContent = this.files[0].name
    console.log(fileChosen);
    
    })
</script>
</body>

</html>