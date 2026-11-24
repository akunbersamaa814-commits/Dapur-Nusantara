# Spesifikasi Teknis — Dapur Nusantara

## 1. Teknologi

| Teknologi | Peran |
|---|---|
| **HTML5** | Struktur halaman (semantic: `header`, `main`, `section`, `article`, `dialog`/`div[role=dialog]`, `footer`) |
| **CSS3** | Seluruh tampilan, ditulis manual (CSS variables, Grid, Flexbox, media query). Tanpa Bootstrap/Tailwind |
| **JavaScript (vanilla)** | Membuka/menutup modal detail resep, menu navbar, dan Peta Daerah |
| **PHP 8.x** | Membaca data JSON, merender card, memproses pencarian & filter kategori |
| **Leaflet 1.9.4** (CDN) | Peta interaktif untuk fitur Peta Daerah, dengan ubin peta OpenStreetMap |

Font & ikon boleh dari CDN (Google Fonts, ikon SVG inline). Satu-satunya library JS adalah
**Leaflet**, dipakai khusus untuk Peta Daerah atas permintaan pengguna (mengikuti web referensi).
File Leaflet dimuat dengan atribut `integrity` (SRI) agar aman.

## 2. Struktur Folder

```
projek_pemweb/
├── index.php                 # Halaman utama: hero, form cari, grid card, modal
├── includes/
│   ├── data.php              # ambil_semua_resep(), cari_resep(), KOORDINAT_DAERAH (titik peta)
│   ├── header.php            # <head>, navbar
│   ├── footer.php            # footer + <script>
│   └── card.php              # Template satu card resep (foto, badge, judul, meta)
├── data/
│   └── resep.json            # Data seluruh resep (lihat docs/DATA_RESEP.md)
├── assets/
│   ├── css/style.css         # Semua styling
│   ├── js/script.js          # Logika modal detail
│   └── img/                  # Gambar makanan (atau pakai URL gambar)
├── docs/                     # Dokumen perencanaan (PRD, spesifikasi, data)
├── CLAUDE.md                 # Aturan kerja untuk Claude
├── PROMPT_MULAI.md           # Prompt untuk membangun website sekali jalan
└── README.md
```

## 3. Alur Data

```
data/resep.json
     │  (file_get_contents + json_decode)
     ▼
includes/data.php ── $semua = ambil_semua_resep(); cari_resep($semua, $_GET['q'], $_GET['kategori'])
     │
     ▼
index.php ── foreach → includes/card.php
     │         setiap card menyimpan data detail:
     │         <button class="card-buka" data-id="rendang"> ...
     │
     └── di akhir halaman: <script id="data-resep" type="application/json">
             <?= json_encode($hasil, JSON_HEX_TAG | JSON_UNESCAPED_UNICODE) ?>
         </script>
                    │
                    ▼
assets/js/script.js ── JSON.parse → klik card → isi & tampilkan modal
```

## 4. Kontrak Fungsi PHP (`includes/data.php`)

```php
function ambil_semua_resep(): array;
// Membaca data/resep.json, mengembalikan array resep.

function cari_resep(array $semua, string $q = '', string $kategori = ''): array;
// - $semua: hasil ambil_semua_resep() (dibaca sekali per halaman)
// - $q dicocokkan (stripos / mb_stripos) ke: nama, daerah, kategori, bahan[]
// - $kategori: jika tidak kosong & bukan "semua", filter kategori persis
// - $q kosong → kembalikan semua (atau sesuai kategori)

function e(string $teks): string;
// Helper: htmlspecialchars($teks, ENT_QUOTES, 'UTF-8')
```

Parameter URL:
- `q` — kata kunci pencarian, di-`trim`, maks. 100 karakter.
- `kategori` — salah satu nilai kategori di data.

## 5. Kontrak JavaScript (`assets/js/script.js`)

- Baca data dari `<script id="data-resep" type="application/json">`.
- Event delegation pada container grid: klik pada `.recipe-card` → `bukaModal(card)`.
- Setiap card punya `<button class="card-buka">` asli (area kliknya diperluas ke seluruh card dengan CSS), jadi `Enter`/`Space` otomatis bekerja.
- `bukaModal(card)`: isi foto + badge, nama, deskripsi, meta, bahan per kelompok, `<ol>` langkah, tips, dan kredit sumber resep/foto; `showModal()`; fokus ke tombol tutup. Scroll halaman dikunci oleh CSS `body:has(.modal[open])`.
- Tutup lewat tombol ✕, klik backdrop, atau `Escape`; fokus kembali ke tombol card yang diklik.
- Tombol hamburger (layar < 768px) membuka/menutup menu navbar dengan class `active` dan `aria-expanded`.

### Peta Daerah
- PHP mencetak `<script id="data-peta">` berisi koordinat daerah (dari `KOORDINAT_DAERAH`)
  yang muncul di hasil pencarian, jadi penanda di peta ikut tersaring oleh pencarian/kategori PHP.
- `siapkanPeta()`: membuat peta Leaflet (pusat Indonesia, zoom scroll aktif setelah peta diklik,
  tombol zoom di kanan bawah), lalu satu penanda per daerah. Penanda = SVG sepasang pria & wanita
  berpakaian adat (warna bergantian), label nama daerah tampil saat disorot/difokus keyboard.
- Klik/Enter pada penanda → popup berisi kartu setiap masakan dari daerah itu (foto, label daerah,
  kredit foto, nama, deskripsi 3 baris, tombol **Lihat Resep** → `bukaModal(id, tombol)`).
- Tombol **Lihat di Peta** di card → `tampilkanDiPeta(daerah)`: gulir ke peta, pusatkan ke daerah, buka popup.
- Kotak cari di atas peta adalah form GET biasa (`q`), diproses PHP seperti form di hero.
- Daerah "Nasional" (Nasi Goreng Kampung) tidak punya titik, jadi tidak ditandai; ada catatan di bawah peta.

## 6. Keamanan Sederhana

- Semua output dari data/input di-escape dengan `e()`.
- Nilai `value` di input pencarian diisi ulang dengan `e($q)`.
- `json_encode` memakai `JSON_HEX_TAG` agar aman disisipkan di `<script>`.

## 7. Cara Menjalankan

Opsi A — PHP built-in server (perlu PHP terpasang, mis. `brew install php`):

```bash
php -S localhost:8000
```

Lalu buka `http://localhost:8000`.

Opsi B — XAMPP/Laragon: salin folder ke `htdocs/` / `www/`, buka `http://localhost/projek_pemweb`.
