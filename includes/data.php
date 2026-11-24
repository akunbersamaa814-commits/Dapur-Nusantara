<?php
/**
 * data.php — fungsi untuk membaca dan mencari data resep.
 * Data diambil dari file data/resep.json (tanpa database).
 */

// Daftar kategori yang dipakai untuk chip filter.
const DAFTAR_KATEGORI = ['Makanan Berat', 'Sup & Soto', 'Camilan', 'Minuman'];

// Koordinat [lintang, bujur] tiap daerah untuk penanda di peta (letak ibu kota provinsi).
const KOORDINAT_DAERAH = [
    // Sumatera
    'Aceh'                      => [5.5483, 95.3238],    // Banda Aceh
    'Sumatera Utara'            => [3.5952, 98.6722],    // Medan
    'Sumatera Barat'            => [-0.9471, 100.4172],  // Padang
    'Riau'                      => [0.5071, 101.4478],   // Pekanbaru
    'Kepulauan Riau'            => [0.9186, 104.4554],   // Tanjung Pinang
    'Jambi'                     => [-1.6101, 103.6131],  // Jambi
    'Sumatera Selatan'          => [-2.9761, 104.7754],  // Palembang
    'Bengkulu'                  => [-3.7928, 102.2608],  // Bengkulu
    'Lampung'                   => [-5.3971, 105.2668],  // Bandar Lampung
    'Kepulauan Bangka Belitung' => [-2.1291, 106.1090],  // Pangkalpinang
    // Jawa
    'DKI Jakarta'               => [-6.2088, 106.8456],  // Jakarta
    'Jawa Barat'                => [-6.9175, 107.6191],  // Bandung
    'Banten'                    => [-6.1200, 106.1503],  // Serang
    'Jawa Tengah'               => [-6.9667, 110.4167],  // Semarang
    'Yogyakarta'                => [-7.7956, 110.3695],  // Yogyakarta
    'Jawa Timur'                => [-7.2575, 112.7521],  // Surabaya
    // Bali & Nusa Tenggara
    'Bali'                      => [-8.6705, 115.2126],  // Denpasar
    'Nusa Tenggara Barat'       => [-8.5833, 116.1167],  // Mataram
    'Nusa Tenggara Timur'       => [-10.1772, 123.6070], // Kupang
    // Kalimantan
    'Kalimantan Barat'          => [-0.0263, 109.3425],  // Pontianak
    'Kalimantan Tengah'         => [-2.2161, 113.9135],  // Palangka Raya
    'Kalimantan Selatan'        => [-3.4425, 114.8310],  // Banjarbaru
    'Kalimantan Timur'          => [-0.5022, 117.1536],  // Samarinda
    'Kalimantan Utara'          => [2.8375, 117.3653],   // Tanjung Selor
    // Sulawesi
    'Sulawesi Utara'            => [1.4748, 124.8421],   // Manado
    'Gorontalo'                 => [0.5435, 123.0568],   // Gorontalo
    'Sulawesi Tengah'           => [-0.8917, 119.8707],  // Palu
    'Sulawesi Barat'            => [-2.6748, 118.8885],  // Mamuju
    'Sulawesi Selatan'          => [-5.1477, 119.4327],  // Makassar
    'Sulawesi Tenggara'         => [-3.9985, 122.5129],  // Kendari
    // Maluku & Papua
    'Maluku'                    => [-3.6954, 128.1814],  // Ambon
    'Maluku Utara'              => [0.7373, 127.5588],   // Sofifi
    'Papua'                     => [-2.5337, 140.7181],  // Jayapura
    'Papua Barat'               => [-0.8615, 134.0620],  // Manokwari
    'Papua Barat Daya'          => [-0.8762, 131.2558],  // Sorong
    'Papua Tengah'              => [-3.3667, 135.4833],  // Nabire
    'Papua Pegunungan'          => [-4.0956, 138.9450],  // Wamena
    'Papua Selatan'             => [-8.4932, 140.4018],  // Merauke
];

// Titik tampil penanda untuk daerah yang ibu kotanya terlalu dekat dengan daerah lain
// (mis. Banten & DKI Jakarta), terlalu dekat tepi peta / kotak cari (Aceh, Kalimantan Utara),
// atau ibu kotanya di garis pantai sehingga di gambar peta jatuh di laut (Kepulauan Riau, Bengkulu).
// Setiap titik tetap berada di DARATAN provinsinya (sudah dicek dengan gambar peta),
// hanya digeser secukupnya agar penanda (26px) tidak bertumpuk.
// Daerah yang tidak ada di sini memakai titik ibu kota dari KOORDINAT_DAERAH.
const TITIK_TAMPIL = [
    'Aceh'                => [5.25, 95.42],
    'Kepulauan Riau'      => [0.97, 104.51],
    'Bengkulu'            => [-3.74, 102.31],
    'Banten'              => [-6.82, 105.65],
    'Jawa Barat'          => [-6.92, 108.07],
    'Jawa Tengah'         => [-6.67, 110.82],
    'Yogyakarta'          => [-7.90, 110.37],
    'Nusa Tenggara Barat' => [-8.58, 116.42],
    'Kalimantan Utara'    => [2.00, 115.80],
    'Sulawesi Selatan'    => [-5.15, 119.53],
    'Maluku'              => [-3.60, 128.23],
    'Papua Barat'         => [-1.01, 134.01],
    'Papua'               => [-2.68, 140.57],
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
 * Posisi penanda sebuah daerah di peta (persen).
 * Memakai TITIK_TAMPIL jika ada, kalau tidak memakai titik asli di KOORDINAT_DAERAH.
 */
function posisi_penanda(string $daerah): array
{
    return posisi_di_peta(TITIK_TAMPIL[$daerah] ?? KOORDINAT_DAERAH[$daerah]);
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
