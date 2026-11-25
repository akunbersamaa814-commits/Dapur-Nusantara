<?php
/**
 * card.php — template satu card resep.
 * Membutuhkan variabel $resep (array) dari perulangan di index.php.
 */
?>
<article class="recipe-card">
    <div class="card-image">
        <?php if ($resep['ada_gambar']): ?>
            <img src="<?= e($resep['gambar']) ?>" alt="<?= e($resep['nama']) ?>"
                 width="1000" height="667" loading="lazy">
        <?php else: ?>
            <div class="card-image__kosong" style="background: <?= e($resep['warna']) ?>"></div>
        <?php endif; ?>
        <span class="badge badge-<?= e(strtolower($resep['kesulitan'])) ?>"><?= e($resep['kesulitan']) ?></span>
    </div>

    <div class="card-content">
        <h3 class="card-title">
            <!-- Tombol asli: bisa diklik, di-Tab, dan ditekan Enter/Spasi tanpa kode tambahan.
                 Area kliknya diperluas ke seluruh card lewat CSS (.card-buka::after). -->
            <button class="card-buka" type="button" data-id="<?= e($resep['id']) ?>"
                    aria-haspopup="dialog"><?= e($resep['nama']) ?></button>
        </h3>
        <p class="card-desc"><?= e($resep['deskripsi']) ?></p>
        <?php [$menit, $jam] = pisah_waktu($resep['waktu']); ?>
        <!-- Info singkat: setiap item tidak terpotong di tengah (lihat .meta-item di CSS) -->
        <div class="card-meta">
            <span class="kategori"><?= e($resep['kategori']) ?></span>
            <span class="meta-item meta-daerah"><span class="sr-only">Daerah: </span><?= e($resep['daerah']) ?></span>
            <span class="meta-item meta-waktu">
                <span class="sr-only">Waktu memasak: </span><?= e($menit) ?>
                <?php if ($jam !== ''): ?><span class="waktu-jam">(<?= e($jam) ?>)</span><?php endif; ?>
            </span>
        </div>
        <?php if (isset(KOORDINAT_DAERAH[$resep['daerah']])): ?>
            <!-- Membawa ke peta dan membuka popup daerah masakan ini (diatur oleh JavaScript) -->
            <button class="card-peta" type="button" data-daerah="<?= e($resep['daerah']) ?>">Lihat di Peta &rarr;</button>
        <?php endif; ?>
    </div>
</article>
