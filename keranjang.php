<?php
include 'config/koneksi.php';
include 'config/header.php';

$keranjang_kosong = (!isset($_SESSION['cart']) || empty($_SESSION['cart']));
?>

<style>
    .cart-wrapper {
        max-width: 800px;
        margin: 0 auto;
    }

    .cart-card {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 15px;
        margin-bottom: 15px;
        transition: transform 0.2s;
    }

    .cart-img {
        width: 85px;
        height: 85px;
        object-fit: cover;
        border-radius: 15px;
    }

    .qty-control {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-top: 8px;
        background: rgba(255, 255, 255, 0.05);
        padding: 5px 10px;
        border-radius: 10px;
        width: fit-content;
    }

    .btn-qty {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 26px;
        height: 26px;
        border-radius: 6px;
        background: rgba(255, 255, 255, 0.1);
        color: white;
        text-decoration: none;
        font-weight: bold;
        transition: 0.3s;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .btn-qty:hover {
        background: var(--accent-green);
        color: white;
    }

    .btn-delete-item {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        border-radius: 12px;
        background: rgba(255, 118, 117, 0.1);
        color: #ff7675;
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 118, 117, 0.2);
    }

    .btn-delete-item:hover {
        background: #ff7675;
        color: white;
        box-shadow: 0 4px 12px rgba(255, 118, 117, 0.3);
    }

    @media (max-width: 768px) {
        .cart-card {
            gap: 12px;
            padding: 12px;
        }
        .cart-img {
            width: 70px;
            height: 70px;
        }
        .cart-card h4 {
            font-size: 0.95rem;
        }
        .qty-control {
            gap: 8px;
            padding: 4px 8px;
        }
        .btn-qty {
            width: 24px;
            height: 24px;
        }
    }
</style>

<main class="container" style="padding-top: 120px; min-height: 90vh; padding-bottom: 120px;">
    <div class="section-title">
        <h2>Keranjang Belanja</h2>
        <p>Sesuaikan jumlah pesanan Anda sebelum lanjut ke WhatsApp.</p>
    </div>

    <?php if ($keranjang_kosong): ?>
        <div class="glass-panel" style="padding: 50px; text-align: center; max-width: 600px; margin: 0 auto;">
            <div style="font-size: 4rem; margin-bottom: 20px;">🛒</div>
            <h3 style="color: white; margin-bottom: 10px;">Keranjangmu masih kosong</h3>
            <p style="color: white; opacity: 0.7; margin-bottom: 30px;">Yuk, belanja sayur segar sekarang!</p>
            <a href="index.php#products" class="nav-btn" style="display: inline-block;">Lihat Produk</a>
        </div>
    <?php else: ?>
        <div class="cart-wrapper">
            <div class="cart-list">
                <?php
                $total_belanja = 0;
                $list_wa = "Halo Sayur Go Solo, saya ingin pesan:\n\n";
                $no = 1;

                foreach ($_SESSION['cart'] as $id => $jumlah):
                    $query = mysqli_query($koneksi, "SELECT * FROM produk WHERE id_produk = '$id'");
                    $item = mysqli_fetch_assoc($query);
                    $subtotal = $item['harga'] * $jumlah;
                    $total_belanja += $subtotal;

                    $list_wa .= $no . ". " . $item['nama_produk'] . " (" . $jumlah . " " . $item['satuan'] . ") - Rp " . number_format($subtotal, 0, ',', '.') . "\n";
                    $no++;
                ?>
                    <div class="glass-panel cart-card">
                        <img src="assets/image/produk/<?= $item['foto']; ?>" alt="<?= $item['nama_produk']; ?>" class="cart-img">
                        
                        <div style="flex: 1;">
                            <h4 style="color: white;"><?= $item['nama_produk']; ?></h4>
                            <p style="color: var(--accent-green); font-weight: 700; margin-bottom: 5px;">Rp <?= number_format($item['harga'], 0, ',', '.'); ?></p>
                            
                            <div class="qty-control">
                                <a href="update_keranjang.php?id=<?= $id; ?>&aksi=kurang" class="btn-qty">-</a>
                                <span style="color: white; font-weight: 600; min-width: 15px; text-align: center;"><?= $jumlah; ?></span>
                                <a href="update_keranjang.php?id=<?= $id; ?>&aksi=tambah" class="btn-qty">+</a>
                            </div>
                        </div>

                        <div style="text-align: right; display: flex; flex-direction: column; align-items: flex-end; justify-content: space-between; min-height: 85px;">
                            <p style="color: white; font-weight: 700; font-size: 1.1rem;">Rp <?= number_format($subtotal, 0, ',', '.'); ?></p>
                            
                            <a href="hapus_item.php?id=<?= $id; ?>" 
                               onclick="return confirm('Hapus item ini?')"
                               class="btn-delete-item">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                </svg>
                            </a>
                        </div>
                    </div>
                <?php endforeach; 
                $list_wa .= "\n*Total Akhir: Rp " . number_format($total_belanja, 0, ',', '.') . "*";
                $url_wa = "https://wa.me/6285713091961?text=" . urlencode($list_wa);
                ?>
            </div>

            <div class="glass-panel" style="padding: 25px; margin-top: 20px; border-top: 2px solid var(--accent-green);">
                <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
                    <h3 style="color: white;">Total</h3>
                    <h2 style="color: var(--accent-green);">Rp <?= number_format($total_belanja, 0, ',', '.'); ?></h2>
                </div>

                <a href="<?= $url_wa; ?>" target="_blank" class="nav-btn" style="display: block; text-align: center; background: #25D366; border: none; padding: 15px; font-weight: 700; border-radius: 12px;">
                    Pesan via WhatsApp
                </a>
                
                <div style="text-align: center; margin-top: 15px;">
                    <a href="hapus_keranjang.php" onclick="return confirm('Kosongkan keranjang?')" style="color: white; opacity: 0.5; font-size: 0.8rem;">Kosongkan Keranjang</a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</main>

<?php include 'config/footer.php'; ?>