<?php 
include '../config/koneksi.php'; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kategori - Admin Sayur Go</title>
    <link rel="stylesheet" href="../assets/style.css">
    
    <style>
        .admin-main { padding: 40px 20px; min-height: 100vh; }
        .modal { 
            display: none; position: fixed; z-index: 1000; left: 0; top: 0; 
            width: 100%; height: 100%; background: rgba(0,0,0,0.8); 
            backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);
        }
        .modal-content { 
            position: relative; top: 50%; left: 50%; transform: translate(-50%, -50%); 
            width: 95%; max-width: 400px; padding: 30px; border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .category-list { margin-top: 20px; display: flex; flex-direction: column; gap: 10px; }
        .list-item { 
            display: flex; 
            align-items: center; 
            padding: 20px; 
            gap: 15px; 
            border-bottom: 1px solid rgba(255,255,255,0.08); 
        }
        .cat-info { flex: 1; }
        .cat-info h4 { color: white; font-size: 1.1rem; font-weight: 600; }
        .cat-info span { color: rgb(4, 157, 20); font-size: 0.8rem; opacity: 0.8; }

        /* BUTTON AKSI OVAL */
        .action-btns { display: flex; gap: 10px; }
        .btn-oval { 
            padding: 8px 18px; border-radius: 50px; font-size: 0.75rem; 
            font-weight: 700; text-align: center; text-transform: uppercase; 
            border: none; cursor: pointer; text-decoration: none;
        }
        
        .btn-oval-edit { background: #f1c40f; color: #1a1a1a; }
        .btn-oval-delete { background: #ff7675; color: white; }

        @media (max-width: 768px) {
            .list-item { padding: 15px 5px; }
            .cat-info h4 { font-size: 1rem; }
        }

        .modal-content input { 
            width: 100%; padding: 12px; margin: 15px 0; border-radius: 10px; 
            border: 1px solid rgba(255,255,255,0.2); background: rgba(255,255,255,0.1); 
            color: white; outline: none; font-family: 'Outfit', sans-serif;
        }
    </style>
</head>
<body>
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>

    <main class="container admin-main">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
            <a href="index.php" style="color: white; opacity: 0.8; display: flex; align-items: center; gap: 8px; font-size: 0.9rem;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"></polyline></svg>
                Dashboard
            </a>
            <button onclick="openAddModal()" class="nav-btn" style="padding: 8px 20px; font-size: 0.8rem;">+ Kategori</button>
        </div>

        <div class="glass-panel" style="padding: 5px 15px;">
            <div class="category-list">
                <?php
                $q = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY nama_kategori ASC");
                if(mysqli_num_rows($q) > 0) {
                    while($row = mysqli_fetch_assoc($q)) { 
                        $id_kat = $row['id_kategori'];
                        $count = mysqli_query($koneksi, "SELECT id_produk FROM produk WHERE id_kategori = '$id_kat'");
                        $total_produk = mysqli_num_rows($count);
                    ?>
                    <div class="list-item">
                        <div class="cat-info">
                            <h4><?= $row['nama_kategori'] ?></h4>
                            <span><?= $total_produk ?> Produk Terkait</span>
                        </div>
                        <div class="action-btns">
                            <button type="button" class="btn-oval btn-oval-edit" 
                                    onclick="openEditModal('<?= $row['id_kategori'] ?>', '<?= addslashes($row['nama_kategori']) ?>')">
                                Edit
                            </button>
                            <a href="hapus_kat.php?id=<?= $row['id_kategori'] ?>" class="btn-oval btn-oval-delete" onclick="return confirm('Hapus kategori ini? Pastikan tidak ada produk di dalamnya.')">Hapus</a>
                        </div>
                    </div>
                    <?php } 
                } else {
                    echo "<p style='color:white; opacity:0.5; text-align:center; padding: 20px;'>Belum ada kategori.</p>";
                } ?>
            </div>
        </div>
    </main>

    <div id="modalTambah" class="modal">
        <div class="glass-panel modal-content">
            <h3 style="color: white; margin-bottom: 10px; text-align: center;">Tambah Kategori</h3>
            <form action="proses_kat.php" method="POST">
                <input type="text" name="nama_kategori" placeholder="Nama Kategori (Misal: Sayur Daun)" required>
                <div style="display: flex; gap: 10px; margin-top: 15px;">
                    <button type="submit" class="nav-btn" style="flex: 2;">Simpan</button>
                    <button type="button" onclick="closeModal('modalTambah')" class="nav-btn" style="flex: 1; background: rgba(255,255,255,0.1);">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalEdit" class="modal">
        <div class="glass-panel modal-content">
            <h3 style="color: white; margin-bottom: 10px; text-align: center;">Edit Kategori</h3>
            <form id="formEditKat" action="proses_edit_kat.php" method="POST">
                <input type="hidden" name="id_kategori" id="edit_id_kat">
                <input type="text" name="nama_kategori" id="edit_nama_kat" required>
                <div style="display: flex; gap: 10px; margin-top: 15px;">
                    <button type="submit" class="nav-btn" style="flex: 2;">Update</button>
                    <button type="button" onclick="closeModal('modalEdit')" class="nav-btn" style="flex: 1; background: rgba(255,255,255,0.1);">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openAddModal() { 
            document.getElementById('modalTambah').style.display = 'block'; 
            document.body.style.overflow = 'hidden';
        }
        
        function openEditModal(id, nama) {
            const form = document.getElementById('formEditKat');
            form.reset();
            document.getElementById('edit_id_kat').value = id;
            document.getElementById('edit_nama_kat').value = nama;
            document.getElementById('modalEdit').style.display = 'block';
            document.body.style.overflow = 'hidden';
        }

        function closeModal(id) { 
            document.getElementById(id).style.display = 'none'; 
            document.body.style.overflow = 'auto';
        }

        document.querySelectorAll('form').forEach(form => {
            form.onsubmit = function() {
                const activeModal = this.closest('.modal');
                const btn = this.querySelector('button[type="submit"]');
                btn.innerHTML = "Processing...";
                btn.disabled = true;
                
                setTimeout(() => { 
                    if(activeModal) activeModal.style.display = 'none'; 
                    document.body.style.overflow = 'auto';
                }, 500);
            };
        });

        window.onclick = function(event) {
            if (event.target.className === 'modal') {
                closeModal(event.target.id);
            }
        }
    </script>
</body>
</html>