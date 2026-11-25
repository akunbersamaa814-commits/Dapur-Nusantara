# PRD — Website Resep Makanan Nusantara

> Product Requirements Document (versi sederhana untuk tugas kuliah Pemrograman Web)

## 1. Ringkasan

Website satu halaman berisi kumpulan resep makanan khas Nusantara. Pengguna dapat
melihat daftar resep dalam bentuk **card**, **mencari** resep berdasarkan nama/daerah/bahan,
dan **membuka detail** resep (bahan + cara memasak) dengan mengklik card.

**Nama website (usulan):** *Dapur Nusantara*

## 2. Tujuan

| Tujuan | Ukuran berhasil |
|---|---|
| Menampilkan resep Nusantara dengan tampilan menarik | Minimal 12 resep tampil sebagai card (kini 86 resep dari 34 provinsi) |
| Memenuhi syarat tugas: HTML, CSS, JS, PHP | Keempat teknologi terpakai dengan peran jelas |
| Pencarian resep berjalan dengan PHP | Hasil pencarian difilter di server (bukan JS) |
| Detail resep tampil dengan JS | Klik card → modal bahan & cara masak muncul tanpa reload |

## 3. Target Pengguna

- Mahasiswa / anak kos yang ingin memasak makanan rumahan.
- Siapa saja yang ingin mengenal kuliner daerah di Indonesia.
- Dosen penguji (harus mudah dinilai: fitur jelas, kode rapi).

## 4. Fitur

### F1 — Daftar Card Resep (PHP + HTML + CSS)
- Halaman utama menampilkan semua resep dalam grid card.
- Setiap card berisi: gambar, nama makanan, asal daerah, kategori, waktu masak, tingkat kesulitan.
- Grid responsif: 1 kolom (HP), 2 kolom (tablet), 3–4 kolom (desktop).

### F2 — Detail Resep via Klik Card (**wajib JavaScript**)
- Klik card → muncul **modal/popup** berisi:
  - Gambar besar, nama, daerah, deskripsi singkat
  - Daftar **bahan-bahan** (list)
  - **Cara memasak** (langkah bernomor)
- Modal dapat ditutup dengan tombol ✕, klik di luar modal, atau tombol `Esc`.
- Data detail diambil dari atribut/JSON yang sudah dicetak PHP ke halaman (tanpa reload).
- Ditulis dengan **vanilla JavaScript** (tanpa jQuery/framework).

### F3 — Pencarian Resep (**wajib PHP**)
- Form pencarian (`method="GET"`, parameter `q`) di bagian atas halaman.
- PHP membaca data resep lalu **memfilter** berdasarkan kata kunci yang cocok dengan
  nama, daerah, kategori, atau bahan (tidak peka huruf besar/kecil).
- Hasil ditampilkan sebagai card (memakai komponen yang sama dengan F1).
- Tampilkan info: *"Menampilkan X resep untuk 'kata kunci'"*.
- Jika tidak ada hasil: tampilkan pesan kosong yang ramah + tombol "Lihat semua resep".
- Input wajib di-escape (`htmlspecialchars`) untuk mencegah XSS.

### F4 — Filter Kategori (opsional / nilai tambah)
- Chip kategori: Semua, Makanan Berat, Sup & Soto, Camilan, Minuman.
- Diproses PHP lewat parameter `kategori` (bisa digabung dengan `q`).

### F5 — Peta Daerah (gambar SVG + JavaScript murni)
- Peta Indonesia (SVG) dengan penanda di setiap daerah asal masakan, plus zoom sederhana (+, −, reset).
- Klik penanda → muncul popup berisi masakan dari daerah itu; tombol **Lihat Resep** membuka detail resep.
- Setiap card punya tombol **Lihat di Peta** yang membawa ke penanda daerahnya.
- Penanda ikut tersaring oleh pencarian dan kategori (PHP).

## 5. Di Luar Lingkup (Tidak Dikerjakan)

- Login / registrasi pengguna
- Tambah/edit/hapus resep (CRUD) dari website
- Database MySQL (data cukup disimpan di file JSON)
- Komentar, rating, favorit

## 6. Halaman & Alur

```
[index.php]
  ├─ Header + Hero (judul, tagline, form pencarian)
  ├─ Chip kategori (opsional)
  ├─ Info hasil pencarian
  ├─ Grid card resep ──klik──► [Modal detail resep (JS)]
  └─ Footer (nama, NIM, mata kuliah)
```

Alur pencarian:
1. User mengetik "rendang" → submit form.
2. Browser memuat `index.php?q=rendang`.
3. PHP memfilter data → mencetak card yang cocok.

## 7. Kebutuhan Non-Fungsional

- **Responsif** (mobile-first), nyaman di layar 360px sampai desktop.
- **Aksesibel**: kontras cukup, `alt` pada gambar, modal bisa dikendalikan keyboard, fokus terlihat.
- **Ringan**: tanpa framework berat; CSS & JS ditulis sendiri.
- **Kode rapi**: dipisah per file (CSS, JS, PHP include), diberi komentar Bahasa Indonesia.

## 8. Kriteria Selesai (Checklist Penilaian)

- [x] Halaman tampil di `http://localhost/...` (XAMPP/Laragon) atau `php -S localhost:8000`
- [x] Minimal 12 resep tampil sebagai card (kini 86 resep dari 34 provinsi)
- [x] Klik card → modal detail muncul (JS), bisa ditutup
- [x] Pencarian berjalan via PHP (`?q=`), termasuk kondisi "tidak ditemukan"
- [x] Tampilan rapi di HP dan desktop
- [x] Tidak ada error di console browser maupun warning PHP
