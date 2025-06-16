<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengelolaan Users</title>
    <style>
        .modal {
        display: none;
        position: fixed;
        z-index: 10;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.5);
        }

        .modal-content {
        background-color: #fff;
        margin: 10% auto;
        padding: 20px;
        width: 350px;
        border-radius: 8px;
        position: relative;
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }

        .close {
        position: absolute;
        top: 10px;
        right: 16px;
        font-size: 22px;
        cursor: pointer;
        }
    </style>

</head>
<body>
    <button onclick="openModal()">Tambah User</button>
    <div id="modal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Form Tambah User</h2>
        <form action="user_store.php" method="POST">
        <input type="text" name="nama" placeholder="Nama Lengkap" required><br><br>
        <input type="text" name="username" placeholder="Username" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <select name="role" required>
            <option value="">-- Pilih Role --</option>
            <option value="admin">Admin</option>
            <option value="viewer">Viewer</option>
        </select><br><br>
        <button type="submit">Simpan</button>
        </form>
    </div>
    </div>
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