<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sayur go Solo</title>
    
    <link rel="stylesheet" href="assets/style.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>
<body>

    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    <div class="blob blob-3"></div>

    <header>
        <nav>
            <div class="logo">
                <img src="assets/image/logo toko sayur.png" alt="Logo">
                SayurGo Solo
            </div>
            <ul class="nav-links" id="navLinks">
                <li><a href="index.php#hero">Beranda</a></li>
                <li><a href="index.php#features">Keunggulan</a></li>
                <li><a href="index.php#products">Produk</a></li>
                <li><a href="index.php#about">Tentang</a></li>
                <li style="position: relative;">
                    <a href="keranjang.php" class="cart-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="9" cy="21" r="1"></circle>
                            <circle cx="20" cy="21" r="1"></circle>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                        </svg>
                        <span class="cart-badge">
                            <?php 
                            if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
                                echo array_sum($_SESSION['cart']); 
                            } else {
                                echo '0';
                            }
                            ?>
                        </span>
                    </a>
                </li>
                
                <?php if(isset($_SESSION['id_user'])): ?>
                    <li><a href="akun.php" class="nav-btn">Akun</a></li>
                <?php else: ?>
                    <li><a href="login.php" class="nav-btn">Login</a></li>
                <?php endif; ?>
            </ul>
            <div class="hamburger" id="hamburger">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div>
        </nav>
    </header>