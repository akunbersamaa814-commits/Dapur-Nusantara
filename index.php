<?php
/**
 * index.php — halaman utama Dapur Nusantara.
 * Alur: ambil parameter pencarian (GET) → filter data dengan PHP → tampilkan card.
 */
require __DIR__ . '/includes/data.php';

// 1. Ambil input pencarian dari URL, rapikan, dan batasi panjangnya.
//    is_string() menjaga agar URL aneh seperti ?q[]=x tidak membuat error.
$q = is_string($_GET['q'] ?? null) ? substr(trim($_GET['q']), 0, 100) : '';
$kategori = is_string($_GET['kategori'] ?? null) ? $_GET['kategori'] : '';
if (!in_array($kategori, DAFTAR_KATEGORI, true)) {
    $kategori = ''; // abaikan kategori yang tidak dikenal
}

// 2. Baca data sekali, lalu cari resep sesuai input (fungsi ada di includes/data.php).
$semua = ambil_semua_resep();
$hasil = cari_resep($semua, $q, $kategori);
$jumlah = count($hasil);

// 3. Data untuk peta: koordinat daerah yang muncul di hasil, dan masakan yang tidak punya titik.
$daerah_hasil = array_unique(array_column($hasil, 'daerah'));
$koordinat = array_intersect_key(KOORDINAT_DAERAH, array_flip($daerah_hasil));
$tanpa_peta = array_filter($hasil, fn ($r) => !isset(KOORDINAT_DAERAH[$r['daerah']]));

// Pasangan warna baju (pria, wanita) untuk penanda, dipakai bergantian per daerah.
$warna_penanda = [
    ['#7C3AED', '#8B5CF6'], ['#DC2626', '#EF4444'], ['#059669', '#10B981'],
    ['#BE185D', '#DB2777'], ['#B45309', '#D97706'], ['#2563EB', '#3B82F6'],
];

include __DIR__ . '/includes/header.php';
?>

<!-- Hero: judul, subjudul, dan form pencarian -->
<header class="hero">
    <h1>Dapur Nusantara</h1>
    <p>Resep Masakan Khas Nusantara</p>

    <!-- Form pencarian: dikirim ke halaman ini sendiri (GET), lalu difilter oleh PHP -->
    <form class="cari" id="cari" action="./#daftar-resep" method="get" role="search">
        <label class="sr-only" for="q">Cari nama masakan, daerah, atau bahan</label>
        <input class="cari__input" type="search" id="q" name="q"
               value="<?= e($q) ?>" placeholder="Cari rendang, Bali, santan..."
               maxlength="100" autocomplete="off">
        <?php if ($kategori !== ''): ?>
            <input type="hidden" name="kategori" value="<?= e($kategori) ?>">
        <?php endif; ?>
        <button class="btn btn-primary" type="submit">Cari Resep</button>
    </form>
</header>

<!-- Peta Daerah: gambar peta SVG + penanda daerah (dibuat PHP). Popup & zoom diatur assets/js/script.js -->
<section class="peta-section" id="peta">
    <div class="container">
        <h2 class="section-title">Peta Kuliner Nusantara</h2>
        <p class="section-sub">Klik penanda daerah di peta untuk melihat masakan khasnya, lalu buka resepnya.</p>

        <div class="peta-wrap">
            <!-- Kotak cari di atas peta: sama seperti form di hero, diproses oleh PHP -->
            <form class="peta-cari" action="./#peta" method="get" role="search">
                <svg aria-hidden="true" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path d="M20 20l-3.5-3.5"/></svg>
                <label class="sr-only" for="q-peta">Cari nama masakan atau daerah</label>
                <input type="search" id="q-peta" name="q" value="<?= e($q) ?>"
                       placeholder="Cari nama masakan atau daerah..." maxlength="100" autocomplete="off">
                <?php if ($kategori !== ''): ?>
                    <input type="hidden" name="kategori" value="<?= e($kategori) ?>">
                <?php endif; ?>
            </form>

            <!-- Area peta yang bisa di-scroll saat diperbesar -->
            <div class="peta" id="peta-area" role="region" aria-label="Peta daerah asal masakan">
                <!-- Lapisan peta: lebarnya diubah oleh tombol zoom, penanda ikut karena posisinya dalam persen -->
                <div class="peta-lapisan" id="peta-lapisan">
                    <img class="peta-gambar" src="assets/img/peta-indonesia.svg" alt="Peta Indonesia"
                         width="1200" height="460" draggable="false">

                    <?php $i = 0; ?>
                    <?php foreach ($koordinat as $daerah => $titik): ?>
                        <?php $posisi = posisi_di_peta($titik); $warna = $warna_penanda[$i++ % count($warna_penanda)]; ?>
                        <!-- Penanda: sepasang pria & wanita berpakaian adat -->
                        <button class="penanda" type="button" data-daerah="<?= e($daerah) ?>"
                                style="left: <?= $posisi['x'] ?>%; top: <?= $posisi['y'] ?>%;"
                                aria-label="Lihat masakan dari <?= e($daerah) ?>" aria-haspopup="dialog">
                            <svg class="penanda__svg" viewBox="0 0 64 64" aria-hidden="true">
                                <path d="M12 50 L16 28 C16 22, 28 22, 28 28 L32 50 Z" fill="<?= $warna[0] ?>"/>
                                <circle cx="22" cy="18" r="6" fill="#FDE68A"/>
                                <path d="M 14 15 Q 22 4 30 15 Z" fill="#F59E0B"/>
                                <rect x="14" y="36" width="16" height="4" fill="#F59E0B"/>
                                <path d="M32 50 L36 28 C36 22, 48 22, 48 28 L52 50 Z" fill="<?= $warna[1] ?>"/>
                                <circle cx="42" cy="18" r="6" fill="#FDE68A"/>
                                <circle cx="49" cy="16" r="4" fill="#1F2937"/>
                                <path d="M 38 12 Q 42 6 46 12 Z" fill="#F59E0B"/>
                                <path d="M 34 36 L 50 36 L 48 40 L 36 40 Z" fill="#F59E0B"/>
                            </svg>
                            <span class="penanda__label"><?= e($daerah) ?></span>
                        </button>
                    <?php endforeach; ?>

                    <!-- Popup masakan: diisi dan diposisikan oleh JavaScript saat penanda diklik -->
                    <div class="peta-popup" id="peta-popup" role="dialog" aria-label="Masakan daerah" hidden>
                        <button class="peta-popup__tutup" type="button" aria-label="Tutup popup">&times;</button>
                        <div id="peta-popup-isi"></div>
                    </div>
                </div>
            </div>

            <!-- Tombol zoom sederhana -->
            <div class="peta-zoom" role="group" aria-label="Zoom peta">
                <button type="button" data-zoom="masuk" aria-label="Perbesar peta">+</button>
                <button type="button" data-zoom="keluar" aria-label="Perkecil peta">&minus;</button>
                <button type="button" data-zoom="reset" aria-label="Kembalikan ukuran peta">
                    <svg aria-hidden="true" viewBox="0 0 24 24"><path d="M3 12a9 9 0 1 0 3-6.7"/><path d="M3 3v6h6"/></svg>
                </button>
            </div>

            <p class="peta-sumber">Peta: Uwe Dedering, CC BY-SA 3.0, via
                <a href="https://commons.wikimedia.org/wiki/File:Indonesia_location_map.svg" target="_blank" rel="noopener">Wikimedia Commons</a></p>

            <?php if (count($koordinat) === 0): ?>
                <p class="peta-kosong">Tidak ada daerah yang cocok dengan pencarian ini.</p>
            <?php endif; ?>
        </div>

        <!-- Di layar sempit (HP), popup dipindah ke sini (di bawah peta) agar tidak keluar layar -->
        <div class="peta-panel" id="peta-panel"></div>

        <?php if (count($tanpa_peta) > 0): ?>
            <p class="peta-catatan">
                <?= e(implode(', ', array_column($tanpa_peta, 'nama'))) ?> adalah masakan nasional,
                jadi tidak ditandai di satu daerah.
            </p>
        <?php endif; ?>
    </div>
</section>

<!-- Filter kategori: tiap tombol adalah link GET yang juga diproses PHP -->
<nav class="filter-section" aria-label="Kategori resep">
    <div class="filter-buttons">
        <a class="filter-btn" href="<?= e(url_cari($q, '')) ?>#daftar-resep"
           <?= $kategori === '' ? 'aria-current="page"' : '' ?>>Semua</a>
        <?php foreach (DAFTAR_KATEGORI as $k): ?>
            <a class="filter-btn" href="<?= e(url_cari($q, $k)) ?>#daftar-resep"
               <?= $kategori === $k ? 'aria-current="page"' : '' ?>><?= e($k) ?></a>
        <?php endforeach; ?>
    </div>
</nav>

<main class="recipe-section" id="daftar-resep">
    <div class="container">
        <h2 class="section-title" role="status">
            <?php if ($q !== ''): ?>
                <?= $jumlah ?> resep untuk “<?= e($q) ?>”<?= $kategori !== '' ? ' di ' . e($kategori) : '' ?>
            <?php elseif ($kategori !== ''): ?>
                <?= e($kategori) ?>
            <?php else: ?>
                Semua Resep
            <?php endif; ?>
        </h2>

        <?php if ($jumlah > 0): ?>
            <div class="recipe-grid" id="grid-resep">
                <?php foreach ($hasil as $resep): ?>
                    <?php include __DIR__ . '/includes/card.php'; ?>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="kosong">
                <h3>Belum ada resep yang cocok</h3>
                <p>Coba kata lain, misalnya nama daerah (Padang, Bali) atau bahan (santan, kacang).</p>
                <a class="btn btn-primary" href="./">Lihat Semua Resep</a>
            </div>
        <?php endif; ?>
    </div>
</main>

<!-- Modal detail resep: isinya diisi oleh assets/js/script.js saat card diklik -->
<dialog class="modal" id="modal-resep" aria-labelledby="modal-nama">
    <button class="modal__tutup" type="button" aria-label="Tutup resep">
        <svg aria-hidden="true" viewBox="0 0 24 24"><path d="M6 6l12 12M18 6L6 18"/></svg>
    </button>
    <div class="recipe-detail">
        <div class="detail-image">
            <img id="modal-gambar" src="" alt="">
            <span class="badge" id="modal-badge"></span>
        </div>

        <div class="detail-header">
            <h2 id="modal-nama"></h2>
            <p class="detail-desc" id="modal-deskripsi"></p>
            <div class="detail-meta" id="modal-meta"></div>
        </div>

        <section class="detail-section">
            <h3>Bahan-bahan</h3>
            <div id="modal-bahan"></div>
        </section>

        <section class="detail-section">
            <h3>Cara Memasak</h3>
            <ol class="instructions-list" id="modal-langkah"></ol>
        </section>

        <section class="detail-section" id="modal-bagian-tips">
            <h3>Tips</h3>
            <ul class="tips-list" id="modal-tips"></ul>
        </section>

        <p class="detail-kredit" id="modal-kredit"></p>
    </div>
</dialog>

<!-- Data resep untuk JavaScript (dicetak oleh PHP dalam format JSON) -->
<script id="data-resep" type="application/json">
<?= json_encode($hasil, JSON_HEX_TAG | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>
</script>
<?php include __DIR__ . '/includes/footer.php'; ?>
