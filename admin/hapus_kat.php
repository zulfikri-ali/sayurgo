<?php
include '../config/koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $cek_produk = mysqli_query($koneksi, "SELECT * FROM produk WHERE id_kategori = '$id'");
    
    if (mysqli_num_rows($cek_produk) > 0) {
        echo "<script>alert('Gagal! Masih ada produk di kategori ini.'); window.location='kategori.php';</script>";
        exit();
    } else {
        mysqli_query($koneksi, "DELETE FROM kategori WHERE id_kategori = '$id'");
        header("Location: kategori.php");
        exit();
    }
} else {
    header("Location: kategori.php");
    exit();
}
?>