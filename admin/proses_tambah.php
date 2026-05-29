<?php
include '../config/koneksi.php';

if (isset($_POST['nama'])) {
    $nama    = $_POST['nama'];
    $harga   = $_POST['harga'];
    $satuan  = $_POST['satuan'];
    $id_kat  = $_POST['id_kategori'];
    $filename = $_FILES['foto']['name'];
    $tmp_name = $_FILES['foto']['tmp_name'];
    
    $ekstensi = pathinfo($filename, PATHINFO_EXTENSION);
    $nama_baru = date('dmYHis') . '_' . str_replace(' ', '_', $nama) . '.' . $ekstensi;
    $path = "../assets/image/produk/" . $nama_baru;

    if (move_uploaded_file($tmp_name, $path)) {
        $query = mysqli_query($koneksi, "INSERT INTO produk (nama_produk, harga, satuan, foto, id_kategori) 
                                         VALUES ('$nama', '$harga', '$satuan', '$nama_baru', '$id_kat')");
        
        header("Location: produk.php");
        exit();
    } else {
        header("Location: produk.php?pesan=gagal_upload");
        exit();
    }
}
?>