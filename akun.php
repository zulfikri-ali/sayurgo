<?php
include 'config/koneksi.php';
include 'config/header.php';
if (!isset($_SESSION['id_user'])) {
    echo "<script>window.location='login.php';</script>";
    exit;
}

$id_user = $_SESSION['id_user'];
$query_user = mysqli_query($koneksi, "SELECT * FROM users WHERE id_user = '$id_user'");
$user = mysqli_fetch_assoc($query_user);
$role_user = $user['role']; 
?>

<style>
    .account-wrapper {
        max-width: 500px;
        margin: 0 auto;
        padding-top: 140px;
        padding-bottom: 100px;
    }

    .profile-info-card {
        padding: 40px;
        text-align: center;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    

    .info-group {
        text-align: left;
        margin-top: 30px;
        background: rgba(255, 255, 255, 0.05);
        padding: 20px;
        border-radius: 15px;
    }

    .info-item {
        margin-bottom: 15px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        padding-bottom: 10px;
    }

    .info-item:last-child {
        margin-bottom: 0;
        border-bottom: none;
    }

    .info-label {
        display: block;
        color: rgb(4, 157, 20);
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .info-value {
        display: block;
        color: white;
        font-size: 1.1rem;
        margin-top: 5px;
    }

    .admin-panel-btn {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        padding: 18px;
        margin-top: 20px;
        background: rgba(241, 196, 15, 0.1);
        border: 1px solid rgba(241, 196, 15, 0.3);
        border-radius: 15px;
        text-decoration: none;
        transition: 0.3s;
    }

    .admin-panel-btn:hover {
        background: rgba(241, 196, 15, 0.2);
        transform: translateY(-3px);
    }

    .admin-icon-box {
        background: #f1c40f;
        padding: 10px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-logout-full {
        display: block;
        width: 100%;
        padding: 15px;
        margin-top: 25px;
        background: rgba(255, 118, 117, 0.1);
        color: #ff7675;
        text-align: center;
        text-decoration: none;
        border-radius: 12px;
        border: 1px solid rgba(255, 118, 117, 0.3);
        font-weight: 600;
        transition: 0.3s;
    }

    .btn-logout-full:hover {
        background: #ff7675;
        color: white;
    }

    @media (max-width: 768px) {
        .account-wrapper {
            padding-left: 20px;
            padding-right: 20px;
            padding-top: 120px;
        }
    }
</style>

<main>
    <div class="account-wrapper">
        <div class="glass-panel profile-info-card">
            
            
            <h2 style="color: white; margin-bottom: 5px;"><?= $user['nama_lengkap']; ?></h2>
            <p style="color: white; opacity: 0.6; font-size: 0.9rem;">Member Sayur Go</p>

            <div class="info-group">
                <div class="info-item">
                    <span class="info-label">Username</span>
                    <span class="info-value"><?= $user['username']; ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Nomor WhatsApp</span>
                    <span class="info-value"><?= $user['no_hp']; ?></span>
                </div>
                
            </div>

            <?php if($role_user == 'admin') : ?>
            <a href="admin/index.php" class="admin-panel-btn">
                <div style="display: flex; align-items: center; gap: 15px;">
                    <div class="admin-icon-box">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#1a1a1a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                    </div>
                    <div style="text-align: left;">
                        <span style="display: block; color: #f1c40f; font-weight: 700; font-size: 0.95rem;">Admin Panel</span>
                    </div>
                </div>
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#f1c40f" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </a>
            <?php endif; ?>

            <a href="logout.php" class="btn-logout-full" onclick="return confirm('Apakah Anda yakin ingin keluar?')">
                Keluar dari Akun
            </a>
        </div>
    </div>
</main>

<?php include 'config/footer.php'; ?>