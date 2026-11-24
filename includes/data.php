<?php
/**
 * data.php — fungsi untuk membaca dan mencari data resep.
 * Data diambil dari file data/resep.json (tanpa database).
 */

// Daftar kategori yang dipakai untuk chip filter.
const DAFTAR_KATEGORI = ['Makanan Berat', 'Sup & Soto', 'Camilan', 'Minuman'];

// Koordinat [lintang, bujur] tiap daerah untuk penanda di peta (letak ibu kota provinsi).
// Daerah "Nasional" tidak punya titik karena masakannya ada di seluruh Indonesia.
const KOORDINAT_DAERAH = [
    'Sumatera Barat'   => [-0.9471, 100.4172],  // Padang
    'Sumatera Selatan' => [-2.9761, 104.7754],  // Palembang
    'DKI Jakarta'      => [-6.2088, 106.8456],  // Jakarta
    'Jawa Barat'       => [-6.9175, 107.6191],  // Bandung
    'Jawa Tengah'      => [-6.9667, 110.4167],  // Semarang
    'Yogyakarta'       => [-7.7956, 110.3695],  // Yogyakarta
    'Jawa Timur'       => [-7.2575, 112.7521],  // Surabaya
    'Bali'             => [-8.6705, 115.2126],  // Denpasar
    'Sulawesi Selatan' => [-5.1477, 119.4327],  // Makassar
    'Papua'            => [-2.5337, 140.7181],  // Jayapura
];

// Batas peta assets/img/peta-indonesia.svg (proyeksi equirectangular / lintang-bujur lurus).
const BATAS_PETA = ['atas' => 6.5, 'bawah' => -11.5, 'kiri' => 94.5, 'kanan' => 141.5];

/**
 * Mengubah titik [lintang, bujur] menjadi posisi di gambar peta dalam persen.
 * x = jarak dari kiri, y = jarak dari atas (0–100%).
 */
function posisi_di_peta(array $titik): array
{
    [$lintang, $bujur] = $titik;
    $x = ($bujur - BATAS_PETA['kiri']) / (BATAS_PETA['kanan'] - BATAS_PETA['kiri']) * 100;
    $y = (BATAS_PETA['atas'] - $lintang) / (BATAS_PETA['atas'] - BATAS_PETA['bawah']) * 100;
    return ['x' => round($x, 2), 'y' => round($y, 2)];
}

/**
 * Helper untuk mencetak teks dengan aman (mencegah XSS).
 */
function e(string $teks): string
{
    return htmlspecialchars($teks, ENT_QUOTES, 'UTF-8');
}

/**
 * Membaca seluruh resep dari file JSON.
 * Setiap resep diberi tambahan 'ada_gambar' (true jika file fotonya ada).
 */
function ambil_semua_resep(): array
{
    $path = __DIR__ . '/../data/resep.json';
    $isi = file_get_contents($path);
    $semua = json_decode($isi, true) ?? [];

    foreach ($semua as &$resep) {
        $resep['ada_gambar'] = is_file(__DIR__ . '/../' . $resep['gambar']);
    }
    unset($resep);

    return $semua;
}

/**
 * Mencari resep (dari $semua) berdasarkan kata kunci dan/atau kategori.
 * Kata kunci dicocokkan ke nama, daerah, kategori, dan bahan (tidak peka huruf besar/kecil).
 */
function cari_resep(array $semua, string $q = '', string $kategori = ''): array
{
    $hasil = [];

    foreach ($semua as $resep) {
        // 1. Filter kategori (dilewati jika kategori kosong).
        if ($kategori !== '' && $resep['kategori'] !== $kategori) {
            continue;
        }

        // 2. Jika tidak ada kata kunci, resep langsung masuk hasil.
        if ($q === '') {
            $hasil[] = $resep;
            continue;
        }

        // 3. Gabungkan semua teks yang boleh dicari, lalu cek apakah mengandung kata kunci.
        //    Bahan disimpan per kelompok (Bahan utama, Bumbu halus, ...), jadi digabung dulu.
        $teks = $resep['nama'] . ' ' . $resep['daerah'] . ' ' . $resep['kategori'];
        foreach ($resep['bahan'] as $kelompok) {
            $teks .= ' ' . implode(' ', $kelompok['isi']);
        }

        if (stripos($teks, $q) !== false) {
            $hasil[] = $resep;
        }
    }

    return $hasil;
}

/**
 * Membuat URL halaman dengan parameter pencarian.
 */
function url_cari(string $q, string $kategori): string
{
    $param = array_filter(['q' => $q, 'kategori' => $kategori], fn ($v) => $v !== '');
    return $param ? '?' . http_build_query($param) : './';
}
