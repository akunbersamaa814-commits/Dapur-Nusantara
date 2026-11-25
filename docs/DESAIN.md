# Keputusan Desain — Dapur Nusantara

Tata letak tetap mengikuti web referensi awal (situs resep "Lezzet Dünyası", font Poppins).
Warnanya kini memakai konsep **Warm Food Aesthetic** (referensi FoodBlog): bersih, hangat, elegan —
latar putih & krem, teks cokelat gelap, aksen cokelat karamel. Konten, fitur, dan kode tetap milik
Dapur Nusantara (HTML + CSS + vanilla JS + PHP).

## Warna (CSS variables di `assets/css/style.css`)

| Token | Nilai | Peran |
|---|---|---|
| `--bg-primary` | `#FFFFFF` | latar utama, navbar, kartu, modal |
| `--bg-secondary` | `#FAF8F5` | latar section krem (hero, footer), tombol kategori |
| `--bg-soft` | `#F3E9DF` | latar hover tombol kategori |
| `--text-primary` | `#29231F` | teks utama, menu navbar, judul resep |
| `--text-secondary` / `--text-muted` | `#77716B` | deskripsi & teks sekunder |
| `--accent-primary` | `#A65E32` | cokelat karamel: logo, tombol utama, kategori aktif, link, fokus keyboard |
| `--accent-secondary` | `#D99A63` | cokelat keemasan: aksen dekoratif (sorotan hover, garis tips) |
| `--accent-hover` | `#874923` | hover tombol dan teks hover |
| `--border-color` | `#EAE3DC` | border kartu, kotak, pemisah section |
| Badge kesulitan | Mudah hijau muda, Sedang krem jingga, Sulit merah muda (teks gelap) | label di foto (warna + teks) |

Urutan latar: hero krem → peta putih → kategori & resep putih → footer krem, dipisah garis tipis.

Footer (krem `#FAF8F5`): nama brand Poppins Bold karamel, deskripsi, ikon Instagram/Facebook/YouTube
dalam lingkaran bergaris keemasan; kolom "Tautan Cepat" dan "Kategori" (judul SemiBold kapital dengan
jarak huruf); kartu newsletter putih (radius 14px, border, shadow lembut) dengan input + tombol "Daftar";
garis tipis lalu copyright (kiri) dan slogan "Resep dari Indonesia, untuk dunia." (kanan).
Responsif: 4 kolom → tablet 2 kolom (brand & newsletter selebar penuh) → HP sama dengan tablet, bagian bawah bertumpuk.
Peta SVG diwarnai terang: laut `#EEF1EF`, daratan Indonesia `#E5CFB3`, negara tetangga `#E4E1DC`.

Kontras (WCAG AA ≥ 4.5:1) sudah dicek: `#29231F` di putih 15.5:1, `#77716B` di krem 4.5:1,
`#A65E32` di putih 4.9:1, teks putih di tombol `#A65E32` 4.9:1 (hover `#874923` 7:1).
`#D99A63` hanya 2.4:1 di putih, jadi **tidak dipakai untuk teks** — hanya untuk aksen dekoratif.

## Tipografi
- **Poppins** 300–700 untuk semua teks. Hero 3.5rem, judul bagian 2rem, isi 18px (16px di HP).

## Tata letak
```
┌ Navbar tetap (blur): logo gradien | Beranda Resep Tentang [Cari Resep] ┐
│ Hero (tengah): judul gradien, subjudul, form cari + tombol gradien     │
│ Chip kategori (pil, tengah)                                            │
│ "Semua Resep" (tengah)                                                 │
│ Grid card 3 kolom: foto 3:2 + badge | judul | deskripsi 3 baris | meta │
│ Footer 4 kolom: brand + sosial | tautan cepat | kategori | newsletter  │
└────────────────────────────────────────────────────────────────────────┘
Modal detail: foto 3:2 (maks. 460px) + badge, judul besar, meta ber-ikon, Bahan (kotak ✦ per
kelompok), Cara Memasak (kotak bernomor lingkaran gradien), Tips, kredit.
```
- Grid otomatis (`minmax(320px, 1fr)`), 1 kolom di bawah 768px.
- Semua foto memakai rasio 3:2 (`aspect-ratio`), sama dengan ukuran file 1000×667.
- Meta card: baris 1 = kategori + ikon pin daerah, baris 2 = ikon jam + waktu
  ("75 menit" diikuti "(1 jam 15 menit)" yang lebih redup). Info + tombol peta selalu di dasar card.
- Navbar menjadi menu hamburger di bawah 768px.

## Gerak
- Halaman fade-in, card muncul bergantian, cahaya hero berdenyut pelan, card naik saat hover.
- Semua animasi dimatikan saat `prefers-reduced-motion` aktif.

## Aksesibilitas yang dijaga
- Card memakai `<button>` asli (bisa Tab/Enter), fokus keyboard terlihat (garis kuning).
- Modal `<dialog>`: tutup dengan ✕, klik di luar, atau Esc; fokus kembali ke card.
- Badge memakai teks, tidak hanya warna. Label pencarian tersedia untuk pembaca layar.
