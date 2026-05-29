<?php
include '../config/koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Sayur Go</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    
    <main class="container" style="padding-top: 80px;">
        <div class="section-title">
            <h2>Admin Dashboard</h2>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 30px; margin-top: 40px;">
            <div class="glass-panel" style="padding: 40px; text-align: center;">
                <a href="produk.php" class="nav-btn" style="display: block;">Kelola Produk</a>
            </div>

            <div class="glass-panel" style="padding: 40px; text-align: center;">
                <a href="kategori.php" class="nav-btn" style="display: block;">Kelola Kategori</a>
            </div>
            
            <div class="glass-panel" style="padding: 40px; text-align: center;">
                <a href="../index.php" class="nav-btn" style="display: block; background: rgba(255,255,255,0.2);">Ke Halaman Utama</a>
            </div>
        </div>
    </main>
</body>
</html>