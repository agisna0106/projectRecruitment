<?php
    include 'header.php';
?>
    <section class="body_tambah_kopi">
        <form action="" method="post">
            <div class="card-tambah-update">
                <label for="nama_kopi">Nama Kopi : </label>
                <input type="text" name="nama_kopi" id="nama_kopi">
                <label for="harga">Harga Jual : </label>
                <div>
                    Rp.<input type="number" name="harga" id="harga" required>
                </div>
                <label for="foto">Foto Kopi : </label>
                <input type="file" name="foto" id="foto" accept="image/*" required>
                <button type="submit" name="submit">Tambah</button>
            </div>
        </form>
        
    </section>
</body>
</html>