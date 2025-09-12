<?php
include "header.php";
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 3) {
    header("Location: dashboard.php");
    exit;
}
require_once '../controller/usersController.php';

$users = new usersController();
$filterRole = isset($_GET['role']) && $_GET['role'] !== '' ? intval($_GET['role']) : null;
$datas = $users->select($filterRole);
$datas = $users->select();
?>
<style>
    .table-container {
    overflow-x: auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

table {
    width: 100%;
    border-collapse: collapse;
    text-align: center;
}

table thead {
    background-color: #C97C5D;
    color: white;
}

table th, table td {
    padding: 12px 10px;
    border-bottom: 1px solid #eee;
}

table tbody tr:hover {
    background-color: #f1e7e1;
}

table button {
    padding: 6px 12px;
    margin: 2px;
    border: none;
    border-radius: 4px;
    color: white;
    background-color: #6c757d;
    cursor: pointer;
}

table button:hover {
    background-color: #5a6268;
}

.btn-hapus {
    padding: 6px 12px;
    margin: 2px;
    border: none;
    border-radius: 4px;
    color: white;
    background-color: #832b2b;
    cursor: pointer;
}

.btn-hapus:hover {
    background-color:rgb(170, 57, 57);
}
</style>

<body>
<section class="content-users">

    <!-- Tombol Tambah dan Modal -->
    <div class="action-bar">
        <button class="btn-add" onclick="openModal()">+ Tambah User</button>

        <!-- Modal Form Tambah User -->
        <div id="modal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <div class="modal-input">
                    <h2>Form Tambah User</h2>
                    <form action="user_store.php" method="POST">
                        <input class="input-field" type="text" name="nama" placeholder="Nama Lengkap" required>
                        <input class="input-field" type="text" name="username" placeholder="Username" required>
                        <input class="input-field" type="password" name="password" placeholder="Password" required>
                        <select class="input-field" name="role" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="3">Admin</option>
                            <option value="2">Viewer</option>
                        </select>
                        <button class="btn-submit" type="submit">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    
    <!-- Modal Edit User -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditModal()">&times;</span>
            <div class="modal-input">
                <h2>Edit User</h2>
                <form action="user_update.php" method="POST">
                    <input class="input-field" type="hidden" name="id" id="edit-id">
                    <input class="input-field" type="text" name="nama" id="edit-nama" placeholder="Nama Lengkap" required>
                    <input class="input-field" type="text" name="username" id="edit-username" placeholder="Username" required>
                    <select class="input-field" name="role" id="edit-role" required>
                        <option value="3">Owner</option>
                        <option value="2">Kasir</option>
                    </select>
                    <button type="submit">Update</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Tabel Data User -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($datas as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['id']) ?></td>
                    <td><?= htmlspecialchars($user['name']) ?></td>
                    <td><?= htmlspecialchars($user['username']) ?></td>
                    <td>
                        <?php
                            switch ($user['role']) {
                                case 1: echo 'Customer'; break;
                                case 2: echo 'Kasir'; break;
                                case 3: echo 'Owner'; break;
                                default: echo 'Tidak Dikenal';
                            }
                        ?>
                    </td>
                    <td>
                        <button onclick="openEditModal(
                            <?= $user['id'] ?>,
                            '<?= $user['name'] ?>',
                            '<?= $user['username'] ?>',
                            '<?= $user['role'] ?>'
                        )">Edit</button>
                        <form action="user_delete.php" method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus user ini?')">
                            <input type="hidden" name="id" value="<?= $user['id'] ?>">
                            <button class="btn-hapus" type="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
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

window.onclick = function(event) {
    let modal = document.getElementById('modal');
    if (event.target === modal) {
        closeModal();
    }
}

function openModal() {
    document.getElementById('modal').style.display = 'block';
}

function closeModal() {
    document.getElementById('modal').style.display = 'none';
}

function openEditModal(id, nama, username, role) {
    document.getElementById('edit-id').value = id;
    document.getElementById('edit-nama').value = nama;
    document.getElementById('edit-username').value = username;
    document.getElementById('edit-role').value = role;
    document.getElementById('editModal').style.display = 'block';
}

function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
}

window.onclick = function(event) {
    if (event.target === document.getElementById('modal')) closeModal();
    if (event.target === document.getElementById('editModal')) closeEditModal();
}
</script>

</body>
</html>
