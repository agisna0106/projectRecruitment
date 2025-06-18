<?php
include "header.php";
require_once '../controller/usersController.php';

$users = new usersController();

$datas = $users->select();
?>
<body>
    <section class="body">
        <div class="action-bar">
            <button class="btn-add" onclick="openModal()">Tambah User</button>
            <div id="modal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal()">&times;</span>
                    <div class="modal-input">
                        <h2>Form Tambah User</h2>
                        <form action="user_store.php" method="POST">
                            <input class="input-field" type="text" name="nama" placeholder="Nama Lengkap" required><br><br>
                            <input class="input-field" type="text" name="username" placeholder="Username" required><br><br>
                            <input class="input-field" type="password" name="password" placeholder="Password" required><br><br>
                            <select class="input-field" name="role" required>
                                <option value="">-- Pilih Role --</option>
                                <option value="admin">Admin</option>
                                <option value="viewer">Viewer</option>
                            </select><br><br>
                            <button class="btn-submit" type="submit">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <th>Id</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Role</th>

                </thead>
            </table>
        </div>
    </section>
    
    <script>
        function openModal() {
            document.getElementById('modal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('modal').style.display = 'none';
        }

        // Tutup modal jika klik di luar konten modal
        window.onclick = function(event) {
        let modal = document.getElementById('modal');
        if (event.target === modal) {
            closeModal();
        }
        }
    </script>
</body>
</html>