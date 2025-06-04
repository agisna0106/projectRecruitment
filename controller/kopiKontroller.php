<?php
include_once '../model/Database.php';

class kopiKontroller
{
    public $db;
    public function __construct()
    {
        $this->db = new Database();
    }

    public function insert()
    {
        $nama_kopi = $_POST['nama_kopi'];
        $harga = $_POST['harga'];
        $foto = $_FILES['foto']['name'];
        $path = "../assets/" . basename($foto);
        move_uploaded_file($_FILES['foto']['tmp_name'], $path);

        $sql = "INSERT INTO kopi (nama_kopi, harga, foto) VALUES ('" . $nama_kopi . "','" . $harga . "','" . $foto . "')";
        $query = $this->db->mysqli->prepare($sql);
        $query->execute() or die($this->db->mysqli->error);
        header("Location: ../view/kopi.php");
        exit;
    }

    public function select()
    {
        $sql = "SELECT * FROM kopi";
        $result = $this->db->mysqli->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function delete($id_kopi) {
        $sql = "DELETE FROM kopi WHERE id_kopi='$id_kopi'";
        $query = $this->db->mysqli->prepare($sql);
        $query->execute() or die($this->db->mysqli->error);
        echo "<script>alert('Data berhasil dihapus');</script>";
    }

    public function __destruct()
    {
        $this->db->mysqli->close();
    }
}
