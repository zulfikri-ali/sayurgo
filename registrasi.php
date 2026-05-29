<?php
session_start();
include 'config/koneksi.php';

if (isset($_SESSION['role'])) {
    header("Location: index.php");
    exit;
}

if (isset($_POST['register'])) {
    $nama   = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $no_hp  = mysqli_real_escape_string($koneksi, $_POST['no_hp']);
    $user   = mysqli_real_escape_string($koneksi, $_POST['user']);
    
    $pass_input = $_POST['pass']; 
    $pass_hashed = password_hash($pass_input, PASSWORD_DEFAULT);

    $cek_user = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$user'");
    if (mysqli_num_rows($cek_user) > 0) {
        $error = "Username sudah terdaftar, gunakan yang lain.";
    } else {
        $insert = mysqli_query($koneksi, "INSERT INTO users (username, password, no_hp, nama_lengkap, role) 
                                 VALUES ('$user', '$pass_hashed', '$no_hp', '$nama', 'customer')");

        if ($insert) {
            echo "<script>alert('Pendaftaran Berhasil! Silakan Login'); window.location='login.php';</script>";
        } else {
            $error = "Terjadi kesalahan saat mendaftar.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Sayur go</title>
    <link rel="stylesheet" href="assets/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        .reg-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 80px 20px 40px 20px;
        }
        .reg-box {
            width: 100%;
            max-width: 450px;
            padding: 35px;
            background: rgba(255, 255, 255, 0.9);
        }
        .form-group { margin-bottom: 15px; }
        .form-group label { 
            display: block; 
            margin-bottom: 6px; 
            font-weight: 600; 
            color: #1a1a1a; 
            font-size: 0.9rem;
        }
        .input-control {
            width: 100%;
            padding: 12px 15px;
            background: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            color: #1a1a1a;
            outline: none;
            font-family: inherit;
            font-size: 1rem;
        }
        .input-control:focus { border-color: var(--accent-green); }
        .btn-block { width: 100%; margin-top: 15px; border: none; cursor: pointer; border-radius: 10px; }
        .error-msg { color: #d63031; text-align: center; margin-bottom: 15px; font-size: 0.85rem; }
    </style>
</head>
<body>
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>

    <div class="reg-wrapper">
        <div class="glass-panel reg-box">
            <div style="text-align: center; margin-bottom: 25px;">
                <h2 style="color: #1a1a1a; font-weight: 700;">Daftar Akun</h2>
                <p style="opacity: 0.6; font-size: 0.85rem; color: #333;">Lengkapi data diri untuk mulai belanja</p>
            </div>

            <?php if(isset($error)): ?>
                <div class="error-msg">⚠️ <?= $error; ?></div>
            <?php endif; ?>

            <form action="" method="post">
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama" class="input-control" placeholder="Nama Anda" required>
                </div>
                <div class="form-group">
                    <label>Nomor WhatsApp</label>
                    <input type="number" name="no_hp" class="input-control" placeholder="08xxx" required>
                </div>
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="user" class="input-control" placeholder="Buat username" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="pass" class="input-control" placeholder="Buat password" required>
                </div>
                
                <button type="submit" name="register" class="nav-btn btn-block">Daftar Sekarang</button>
            </form>

            <div style="text-align: center; margin-top: 20px; font-size: 0.9rem; color: #555;">
                Sudah punya akun? <a href="login.php" style="color: var(--accent-green); font-weight: 700;">Login</a>
            </div>
        </div>
    </div>
</body>
</html>