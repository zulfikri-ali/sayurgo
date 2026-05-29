<?php
include '../config/koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $data = mysqli_query($koneksi, "SELECT foto FROM produk WHERE id_produk = '$id'");
    $row = mysqli_fetch_assoc($data);
    if ($row['foto'] != "") {
        unlink("../assets/image/produk/" . $row['foto']);
    }
    mysqli_query($koneksi, "DELETE FROM produk WHERE id_produk = '$id'");
    header("Location: produk.php");
    exit();
} else {
    header("Location: produk.php");
    exit();
}
?>