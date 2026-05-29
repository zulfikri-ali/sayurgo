<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'config/koneksi.php'; 

if (isset($_POST['add_to_cart'])) {
    $id_produk = $_POST['id_produk'];
    
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$id_produk])) {
        $_SESSION['cart'][$id_produk]++;
    } else {
        $_SESSION['cart'][$id_produk] = 1;
    }
    
    header("Location: index.php#products");
    exit;
}

include 'config/header.php'; 
?>

<main>
    <section id="hero" class="hero container">
        <div class="hero-content">
            <h1>Sayur Segar<br>Tanpa Harus Pergi Ke Pasar</h1>
            <p>Belanja sayur dan buah segar kini tanpa perlu keluar rumah dengan SayurGo.</p>
            <a href="#products" class="btn-glass">
                Mau Masak Apa Hari Ini?
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </a>
        </div>
        <div class="hero-image">
            <div class="hero-card glass-panel">
                <img src="assets/image/peti sayur.png" alt="Peti Sayur">
            </div>
        </div>
    </section>

    <section id="features" class="features container">
        <div class="section-title">
            <h2>Kenapa Kami?</h2>
            <p>karena kami cepat dan tepat waktu sehingga sayuran tetap segar sampai ke tangan kamu</p>
        </div>
        
        <div class="horizontal-scroll-wrapper">
            <div class="features-grid">
                <div class="feature-card glass-panel">
                    <div class="feature-icon">✦</div>
                    <h3>Kesegaran Terjamin</h3>
                    <p>Sayur segar sampai tangan kamu seperti baru dipetik dari kebun.</p>
                </div>
                <div class="feature-card glass-panel">
                    <div class="feature-icon">✿</div>
                    <h3>Higenis dan Berkualitas</h3>
                    <p>Belanja sayur tanpa khawatir, karena kualitas kami terjamin fresh,higenis dan berkualitas pastinya.</p>
                </div>
                <div class="feature-card glass-panel">
                    <div class="feature-icon">⚡</div>
                    <h3>Order mudah dan cepat</h3>
                    <p>order via whatsapp mudah dan cepat sehingga sayuran tetap segar dan tiba tepat waktu.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="products" class="products container">
        <div class="section-title">
            <h2>Koleksi Sayur</h2>
            <p>Pilihan terbaik musim ini dengan harga transparan.</p>
        </div>

        <div class="category-tabs">
            <button class="tab-btn active" data-filter="all">Semua</button>
            <?php
            $query_cat = mysqli_query($koneksi, "SELECT * FROM kategori");
            while($cat = mysqli_fetch_assoc($query_cat)) {
                echo '<button class="tab-btn" data-filter="cat-'.$cat['id_kategori'].'">'.$cat['nama_kategori'].'</button>';
            }
            ?>
        </div>

        <div class="search-container container" style="margin-bottom: 25px;">
            <div class="glass-panel" style="padding: 10px 20px; border-radius: 50px; display: flex; align-items: center; gap: 15px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="opacity: 0.6;"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                <input type="text" id="searchInput" placeholder="Cari sayur segar..." style="background: none; border: none; color: white; width: 100%; outline: none; font-family: 'Outfit', sans-serif;">
            </div>
        </div>

        <div class="products-grid" id="products-grid">
            <?php
            $query_prod = mysqli_query($koneksi, "SELECT produk.*, kategori.id_kategori 
                                                 FROM produk 
                                                 LEFT JOIN kategori ON produk.id_kategori = kategori.id_kategori 
                                                 ORDER BY id_produk DESC");
            
            while($row = mysqli_fetch_assoc($query_prod)) {
            ?>
                <div class="product-card glass-panel all cat-<?php echo $row['id_kategori']; ?>">
                    <div class="product-img">
                        <img src="assets/image/produk/<?php echo $row['foto']; ?>" alt="">
                    </div>
                    <div class="product-info">
                        <h3 class="product-title"><?php echo $row['nama_produk']; ?></h3>
                        <div class="product-price">Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?> / <?php echo $row['satuan']; ?></div>
                        
                        <div class="product-actions" style="display: flex; gap: 8px; margin-top: auto;">
                            <form action="" method="post" style="flex: 1;">
                                <input type="hidden" name="id_produk" value="<?php echo $row['id_produk']; ?>">
                                <button type="submit" name="add_to_cart" class="btn-cart-add" style="width: 100%; padding: 10px; border-radius: 12px; border: 1px solid rgba(201, 102, 9, 0.55); background: rgba(201, 102, 9, 0.22); color: rgba(201, 102, 9, 0.89); cursor: pointer; display: flex; align-items: center; justify-content: center;">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                                </button>
                            </form>
                            
                            <a href="https://wa.me/6285713091961?text=Halo Sayur Go Solo, saya mau pesan langsung: <?php echo $row['nama_produk']; ?>" class="btn-buy" style="flex: 2; text-align: center; padding: 10px; border-radius: 12px; background: var(--accent-green); color: white; font-weight: 600; font-size: 0.85rem; display: flex; align-items: center; justify-content: center;">
                                Beli
                            </a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <div id="empty-msg" style="display: none; text-align: center; width: 100%; padding: 50px 0;">
            <div class="glass-panel" style="display: inline-block; padding: 30px 50px; border: 1px dashed rgba(255,255,255,0.3);">
                <h3 style="color: var(--accent-green); margin-bottom: 10px;">Stok Sedang Kosong</h3>
                <p style="color: white; opacity: 0.8;">Produk untuk kategori ini belum tersedia saat ini.</p>
            </div>
        </div>
    </section>

    <section id="about" class="about-section container">
        <div class="glass-panel about-card">
            <div class="about-img-wrapper">
                <img src="assets/image/logo toko sayur.png" alt="Logo Sumber Pangan Jaya">
            </div>
            <div class="about-content">
                <h2>Tentang SayurGo Solo</h2>
                <p>Berawal dari pasar tradisional di Solo, kami hadir secara digital untuk memastikan setiap keluarga mendapatkan akses sayuran dan buah premium langsung dari petani lokal.</p>
                <p>Setiap produk melalui kontrol kualitas yang ketat sebelum sampai di depan pintu rumah Anda.</p>
                <div class="about-stats">
                    <div class="stat-item"><h4>50+</h4><p>Mitra Petani</p></div>
                    <div class="stat-item"><h4>100%</h4><p>Organik</p></div>
                    <div class="stat-item"><h4>Solo</h4><p>Operasional</p></div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'config/footer.php'; ?>