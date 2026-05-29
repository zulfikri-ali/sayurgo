<?php
session_start();
unset($_SESSION['cart']);
header("Location: keranjang.php");
exit;
?>