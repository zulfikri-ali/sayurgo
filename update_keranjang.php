<?php
session_start();

if (isset($_GET['id']) && isset($_GET['aksi'])) {
    $id = $_GET['id'];
    $aksi = $_GET['aksi'];

    if ($aksi == 'tambah') {
        $_SESSION['cart'][$id]++;
    } elseif ($aksi == 'kurang') {
        if ($_SESSION['cart'][$id] > 1) {
            $_SESSION['cart'][$id]--;
        } else {
            // Jika jumlah sudah 1 lalu dikurang, hapus item
            unset($_SESSION['cart'][$id]);
        }
    }
}

header("Location: keranjang.php");
exit;
?>