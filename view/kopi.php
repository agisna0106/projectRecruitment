<?php
    include 'header.php';
?>
<section class="body">
        <div class="action-bar">
            <a href="tambahKopi.php"><button class="btn-add">+ Tambah Kopi</button></a>
        </div>
        <div class="kopi-container">
            <?php
            for($i=0; $i<10; $i++):
            ?>
                <div class="kopi-card">
                    <img class="kopi-image" src="../assets/americano.png" alt="">
                    <p>Americano</p>
                    <div class="btn-edit-delete">    
                        <button class="btn-edit" >Edit</button>
                        <button class="btn-delete" >Hapus</button>
                    </div>
                </div>
            <?php endfor?>
        </div>
        
    </section>
    <footer></footer>
</body>
</html>