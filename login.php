<?php
session_start();
include 'config/koneksi.php';

if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'admin') {
        header("Location: admin/index.php");
    } else {
        header("Location: index.php");
    }
    exit;
}

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['user']);
    $password = $_POST['pass']; 

    $query = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username'");
    
    if (mysqli_num_rows($query) === 1) {
        $data = mysqli_fetch_assoc($query);

        if (password_verify($password, $data['password'])) {
            $_SESSION['id_user']  = $data['id_user'];
            $_SESSION['username'] = $data['username'];
            $_SESSION['role']     = $data['role'];

            if ($data['role'] == 'admin') {
                echo "<script>alert('Login Admin Berhasil'); window.location='admin/index.php';</script>";
            } else {
                echo "<script>alert('Login Berhasil'); window.location='index.php';</script>";
            }
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sayur go</title>
    <link rel="stylesheet" href="assets/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .login-box {
            width: 100%;
            max-width: 400px;
            padding: 40px;
            background: rgba(255, 255, 255, 0.85); 
        }
        .form-group { margin-bottom: 20px; }
        .form-group label { 
            display: block; 
            margin-bottom: 8px; 
            font-weight: 600; 
            color: #1a1a1a; 
            font-size: 0.95rem;
        }
        .input-control {
            width: 100%;
            padding: 12px 16px;
            background: rgba(255, 255, 255, 0.5);
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            color: #1a1a1a; 
            outline: none;
            font-family: inherit;
        }
        .input-control::placeholder { color: rgba(0, 0, 0, 0.4); }
        .input-control:focus { border-color: var(--accent-green); box-shadow: 0 0 0 3px rgba(74, 222, 128, 0.1); }
        .btn-block { width: 100%; margin-top: 10px; border: none; cursor: pointer; border-radius: 12px; }
        .error-msg { color: #d63031; text-align: center; margin-bottom: 15px; font-size: 0.85rem; font-weight: 500; }
        .footer-link { text-align: center; margin-top: 20px; font-size: 0.9rem; color: #555; }
        .footer-link a { color: var(--accent-green); font-weight: 700; }
    </style>
</head>
<body>
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>

    <div class="login-wrapper">
        <div class="glass-panel login-box">
            <div style="text-align: center; margin-bottom: 30px;">
                <img src="assets/image/logo toko sayur.png" alt="Logo" style="width: 70px; margin: 0 auto 15px;">
                <h2 style="font-weight: 700; color: #1a1a1a; letter-spacing: -0.5px;">Login Sayur Go</h2>
                <p style="opacity: 0.6; font-size: 0.85rem; color: #333;">Masukkan akun Sumber Pangan Jaya</p>
            </div>

            <?php if(isset($error)): ?>
                <div class="error-msg">⚠️ <?= $error; ?></div>
            <?php endif; ?>

            <form action="" method="post">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="user" class="input-control" placeholder="Masukkan username" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="pass" class="input-control" placeholder="Masukkan password" required>
                </div>
                <button type="submit" name="login" class="nav-btn btn-block">Masuk Sekarang</button>
            </form>

            <div class="footer-link">
                Belum punya akun? <a href="registrasi.php">Daftar</a>
            </div>
            
            <div style="text-align: center; margin-top: 15px;">
                <a href="index.php" style="font-size: 0.8rem; color: #888;">← Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</body>
</html>