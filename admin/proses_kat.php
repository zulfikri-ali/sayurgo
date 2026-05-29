<?php
include '../config/koneksi.php';

if (isset($_POST['nama_kategori'])) {
    $nama_kat = $_POST['nama_kategori'];

    $query = mysqli_query($koneksi, "INSERT INTO kategori (nama_kategori) VALUES ('$nama_kat')");
    header("Location: kategori.php");
    exit();
} else {
    header("Location: kategori.php");
    exit();
}
?>