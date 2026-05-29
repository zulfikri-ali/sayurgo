<?php
include '../config/koneksi.php';
if (isset($_POST['id_produk'])) {
    $id     = $_POST['id_produk'];
    $nama   = $_POST['nama'];
    $harga  = $_POST['harga'];
    $satuan = $_POST['satuan'];
    $id_kat = $_POST['id_kategori'];

    $foto   = $_FILES['foto']['name'];

    if ($foto != "") {
        $ekstensi = pathinfo($foto, PATHINFO_EXTENSION);
        $nama_baru = date('dmYHis').'_'.$id.'.'.$ekstensi;
        move_uploaded_file($_FILES['foto']['tmp_name'], "../assets/image/produk/".$nama_baru);
        
        $query = "UPDATE produk SET nama_produk='$nama', harga='$harga', satuan='$satuan', id_kategori='$id_kat', foto='$nama_baru' WHERE id_produk='$id'";
    } else {
        $query = "UPDATE produk SET nama_produk='$nama', harga='$harga', satuan='$satuan', id_kategori='$id_kat' WHERE id_produk='$id'";
    }

    mysqli_query($koneksi, $query);
    header("Location: produk.php");
    exit();
}
?>