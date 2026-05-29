<?php 
include '../config/koneksi.php'; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Produk - Admin Sayur Go</title>
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
            width: 95%; max-width: 500px; padding: 30px; border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .product-list { margin-top: 20px; display: flex; flex-direction: column; gap: 10px; }
        .list-item { display: flex; align-items: center; padding: 15px; gap: 15px; border-bottom: 1px solid rgba(255,255,255,0.08); }

        .prod-img-admin { width: 85px; height: 85px; object-fit: cover; border-radius: 18px; border: 1px solid rgba(255,255,255,0.2); flex-shrink: 0; }
        .prod-info { flex: 1; }
        .prod-info h4 { color: white; font-size: 1.1rem; margin-bottom: 4px; font-weight: 600; }
        .prod-info p { color: #e67e22; font-weight: 700; font-size: 0.95rem; }

        .action-btns { display: flex; flex-direction: column; gap: 8px; }
        .btn-oval { 
            padding: 8px 20px; border-radius: 50px; font-size: 0.75rem; 
            font-weight: 700; text-align: center; text-transform: uppercase; 
            border: none; cursor: pointer; text-decoration: none;
        }
        
        .btn-oval-edit { background: #f1c40f; color: #1a1a1a; }
        .btn-oval-delete { background: #ff7675; color: white; }

        @media (max-width: 768px) {
            .prod-img-admin { width: 75px; height: 75px; }
            .list-item { padding: 12px 5px; gap: 12px; }
        }

        .modal-content input, .modal-content select { 
            width: 100%; padding: 12px; margin: 8px 0; border-radius: 10px; 
            border: 1px solid rgba(255,255,255,0.2); background: rgba(255,255,255,0.1); 
            color: white; outline: none; font-family: 'Outfit', sans-serif;
        }
        .modal-content select option { background-color: #203a43; color: white; }
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
            <button onclick="openAddModal()" class="nav-btn" style="padding: 8px 20px; font-size: 0.8rem;">+ Baru</button>
        </div>

        <div class="glass-panel" style="padding: 5px 15px;">
            <div class="product-list">
                <?php
                $q = mysqli_query($koneksi, "SELECT * FROM produk ORDER BY id_produk DESC");
                if(mysqli_num_rows($q) > 0) {
                    while($row = mysqli_fetch_assoc($q)) { ?>
                    <div class="list-item">
                        <img src="../assets/image/produk/<?= $row['foto'] ?>" class="prod-img-admin">
                        <div class="prod-info">
                            <h4><?= $row['nama_produk'] ?></h4>
                            <p>Rp <?= number_format($row['harga'],0,',','.') ?> <small style="color:white; opacity:0.5;">/ <?= $row['satuan'] ?></small></p>
                        </div>
                        <div class="action-btns">
                            <button type="button" class="btn-oval btn-oval-edit" 
                                    onclick="openEditModal('<?= $row['id_produk'] ?>', '<?= addslashes($row['nama_produk']) ?>', '<?= $row['harga'] ?>', '<?= addslashes($row['satuan']) ?>', '<?= $row['id_kategori'] ?>')">
                                Edit
                            </button>
                            <a href="hapus.php?id=<?= $row['id_produk'] ?>" class="btn-oval btn-oval-delete" onclick="return confirm('Hapus produk ini?')">Hapus</a>
                        </div>
                    </div>
                    <?php } 
                } else {
                    echo "<p style='color:white; opacity:0.5; text-align:center; padding: 20px;'>Belum ada produk.</p>";
                } ?>
            </div>
        </div>
    </main>

    <div id="modalTambah" class="modal">
        <div class="glass-panel modal-content">
            <h3 style="color: white; margin-bottom: 20px; text-align: center;">Tambah Produk</h3>
            <form action="proses_tambah.php" method="POST" enctype="multipart/form-data">
                <input type="text" name="nama" placeholder="Nama Produk" required>
                <input type="number" name="harga" placeholder="Harga" required>
                <input type="text" name="satuan" placeholder="Satuan (kg/ikat)" required>
                <select name="id_kategori" required>
                    <option value="" disabled selected>Pilih Kategori</option>
                    <?php 
                    $cat = mysqli_query($koneksi, "SELECT * FROM kategori");
                    while($c = mysqli_fetch_assoc($cat)) { echo "<option value='".$c['id_kategori']."'>".$c['nama_kategori']."</option>"; }
                    ?>
                </select>
                <div style="margin: 10px 0;">
                    <input type="file" name="foto" onchange="validateSize(this)" required>
                    <small style="color: #ff7675; font-size: 0.7rem; display: block; margin-top: 2px;">* Maksimal 2 MB</small>
                </div>
                <div style="display: flex; gap: 10px; margin-top: 25px;">
                    <button type="submit" class="nav-btn" style="flex: 2;">Simpan</button>
                    <button type="button" onclick="closeModal('modalTambah')" class="nav-btn" style="flex: 1; background: rgba(255,255,255,0.1);">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalEdit" class="modal">
        <div class="glass-panel modal-content">
            <h3 style="color: white; margin-bottom: 20px; text-align: center;">Edit Produk</h3>
            <form id="formEdit" action="proses_edit.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_produk" id="edit_id">
                <input type="text" name="nama" id="edit_nama" required>
                <input type="number" name="harga" id="edit_harga" required>
                <input type="text" name="satuan" id="edit_satuan" required>
                <select name="id_kategori" id="edit_kategori" required>
                    <?php 
                    $cat2 = mysqli_query($koneksi, "SELECT * FROM kategori");
                    while($c2 = mysqli_fetch_assoc($cat2)) { echo "<option value='".$c2['id_kategori']."'>".$c2['nama_kategori']."</option>"; }
                    ?>
                </select>
                <div style="margin: 10px 0;">
                    <p style="color: white; font-size: 0.7rem; margin-top: 10px; opacity: 0.7;">*Biarkan kosong jika tidak ganti foto</p>
                    <input type="file" name="foto" onchange="validateSize(this)">
                    <small style="color: #ff7675; font-size: 0.7rem; display: block; margin-top: 2px;">* Maksimal 2 MB</small>
                </div>
                <div style="display: flex; gap: 10px; margin-top: 25px;">
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
        
        function openEditModal(id, nama, harga, satuan, kategori) {
            const form = document.getElementById('formEdit');
            form.reset();
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_nama').value = nama;
            document.getElementById('edit_harga').value = harga;
            document.getElementById('edit_satuan').value = satuan;
            document.getElementById('edit_kategori').value = kategori;
            document.getElementById('modalEdit').style.display = 'block';
            document.body.style.overflow = 'hidden';
        }

        function closeModal(id) { 
            document.getElementById(id).style.display = 'none'; 
            document.body.style.overflow = 'auto';
        }

        function validateSize(input) {
            const fileSize = input.files[0].size / 1024 / 1024; 
            if (fileSize > 2) {
                alert("File terlalu besar! Maksimal 2MB."); 
                input.value = ""; 
            }
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