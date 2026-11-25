<?php /* footer.php — kaki halaman dan pemanggilan JavaScript. */ ?>
<?php
// Kategori daerah di footer: setiap link memakai pencarian PHP biasa (?q=...),
// misalnya "Sumatera" menampilkan resep dari semua provinsi di Sumatera.
$kategori_daerah = ['Sumatera', 'Jawa', 'Bali', 'Papua', 'Sulawesi', 'Kalimantan'];
?>
<footer class="footer" id="tentang">
    <div class="footer-grid">
        <!-- 1. Kolom brand -->
        <div class="footer-kolom footer-kolom--brand">
            <h2 class="footer-brand">Dapur Nusantara</h2>
            <p class="footer-desk">Kumpulan resep masakan khas daerah di Indonesia, dari Sumatera sampai Papua,
               lengkap dengan bahan dan cara memasak langkah demi langkah.</p>
        </div>

        <!-- 2. Tautan cepat -->
        <nav class="footer-kolom" aria-label="Tautan cepat">
            <h3 class="footer-judul">Tautan Cepat</h3>
            <ul class="footer-daftar">
                <li><a href="./">Beranda</a></li>
                <li><a href="#daftar-resep">Daftar Resep</a></li>
                <li><a href="#peta">Peta Daerah</a></li>
                <li><a href="#cari">Cari Resep</a></li>
            </ul>
        </nav>

        <!-- 3. Kategori daerah (pencarian PHP) -->
        <nav class="footer-kolom" aria-label="Kategori daerah">
            <h3 class="footer-judul">Kategori</h3>
            <ul class="footer-daftar">
                <?php foreach ($kategori_daerah as $nama_daerah): ?>
                    <li><a href="<?= e(url_cari($nama_daerah, '')) ?>#daftar-resep"><?= e($nama_daerah) ?></a></li>
                <?php endforeach; ?>
            </ul>
        </nav>

        <!-- 4. Kartu newsletter (pesan terima kasih diatur assets/js/script.js) -->
        <div class="footer-kolom">
            <div class="footer-kartu">
                <h3 class="footer-kartu__judul">Temukan Resep Baru</h3>
                <p class="footer-kartu__desk">Dapatkan inspirasi masakan Nusantara langsung melalui email Anda.</p>
                <form class="footer-langganan" id="form-langganan" action="#tentang" method="post">
                    <label class="sr-only" for="email-langganan">Alamat email</label>
                    <input type="email" id="email-langganan" name="email" placeholder="Email Anda"
                           autocomplete="email" required>
                    <button class="footer-langganan__tombol" type="submit">Daftar</button>
                </form>
                <p class="footer-langganan__pesan" id="pesan-langganan" aria-live="polite"></p>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <p>&copy; 2026 Dapur Nusantara. Seluruh hak cipta dilindungi.</p>
        <p class="footer-slogan">Resep dari Indonesia, untuk dunia.</p>
    </div>

    <!-- Watermark identitas tugas: judul/tema, nama, dan NIM pembuat -->
    <div class="footer-watermark">
        <p class="footer-watermark__judul">Dapur Nusantara</p>
        <ul class="footer-watermark__tim" aria-label="Pembuat">
            <li>M. Fasha Bintang Pratama <span>(202531081)</span></li>
            <li>Satria Manurung <span>(202531123)</span></li>
        </ul>
    </div>
</footer>

<script src="assets/js/script.js"></script>
</body>
</html>
