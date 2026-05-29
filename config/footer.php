<footer>
    <div class="container">
        <div class="footer-content">
            <div class="footer-col">
                <h3 style="color: var(--accent-green);">SayurGo Solo</h3>
                <p style="opacity: 0.7;">Hidup Sehat Tanpa Ribet Keluar Rumah.</p>
            </div>
            <div class="footer-col">
                <h4>Menu</h4>
                <a href="#hero">Beranda</a>
                <a href="#products">Produk</a>
                <a href="#features">Keunggulan</a>
            </div>
            <div class="footer-col">
                <h4>Sosial Media</h4>
                <a href="#">Instagram</a>
                <a href="#">Threads</a>
                <a href="#">Tiktok</a>
            </div>
        </div>
        <p style="margin-top: 2rem; opacity: 0.5; font-size: 0.8rem; text-align: center;">
            &copy; <?php echo date('Y'); ?> Sumber Pangan Jaya Solo. Powered by SayurGo.
        </p>
    </div>

    <div class="bottom-nav">
        <a href="index.php#hero" class="nav-item">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
            <span>Beranda</span>
        </a>
        <a href="index.php#products" class="nav-item">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
            <span>Produk</span>
        </a>
        
        <a href="keranjang.php" class="nav-item" style="position: relative;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
            <span class="cart-badge">
                <?php 
                if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
                    echo array_sum($_SESSION['cart']); 
                } else {
                    echo '0';
                }
                ?>
            </span>
            <span>Keranjang</span>
        </a>

        <?php if(isset($_SESSION['id_user'])): ?>
            <a href="akun.php" class="nav-item">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                <span>Akun</span>
            </a>
        <?php else: ?>
            <a href="login.php" class="nav-item">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path><polyline points="10 17 15 12 10 7"></polyline><line x1="15" y1="12" x2="3" y2="12"></line></svg>
                <span>Login</span>
            </a>
        <?php endif; ?>
    </div>
</footer>

    <a href="https://wa.me/6285713091961" class="float-wa">
        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
    </a>

    <script>
        const hamburger = document.getElementById('hamburger');
        const nav = document.querySelector('nav');
        hamburger.addEventListener('click', () => nav.classList.toggle('active'));

        const filterButtons = document.querySelectorAll('.tab-btn');
        const productCards = document.querySelectorAll('.product-card');
        const emptyMsg = document.getElementById('empty-msg');

        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                filterButtons.forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');

                const filterValue = button.getAttribute('data-filter');
                let visibleCount = 0;

                productCards.forEach(card => {
                    if (filterValue === 'all' || card.classList.contains(filterValue)) {
                        card.style.display = 'flex';
                        card.style.animation = 'fadeIn 0.5s ease forwards';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                emptyMsg.style.display = (visibleCount === 0) ? 'block' : 'none';
            });
        });

        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

            
            const searchInput = document.getElementById('searchInput');

            searchInput.addEventListener('keyup', function() {
                const filter = searchInput.value.toLowerCase();
                const cards = document.querySelectorAll('.product-card');

                cards.forEach(card => {
                    const title = card.querySelector('.product-title').innerText.toLowerCase();
                    if (title.includes(filter)) {
                        card.style.display = 'flex';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
    </script>
</body>
</html>