<?php
include '../config/koneksi.php';

if (isset($_POST['id_kategori'])) {
    $id = $_POST['id_kategori'];
    $nama = $_POST['nama_kategori'];

    mysqli_query($koneksi, "UPDATE kategori SET nama_kategori = '$nama' WHERE id_kategori = '$id'");
    
    header("Location: kategori.php");
    exit();
}
?>