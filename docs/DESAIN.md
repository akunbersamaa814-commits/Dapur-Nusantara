# Keputusan Desain — Dapur Nusantara

Desain mengikuti web referensi pilihan pengguna (situs resep "Lezzet Dünyası"):
tema gelap, aksen gradien oranye–kuning, font Poppins. Yang ditiru hanya gaya tampilannya;
konten, fitur, dan kode tetap milik Dapur Nusantara (HTML + CSS + vanilla JS + PHP).

## Warna (CSS variables di `assets/css/style.css`)

| Token | Nilai | Peran |
|---|---|---|
| `--bg-primary` | `#0f0f0f` | latar halaman |
| `--bg-secondary` | `#1a1a1a` | latar footer |
| `--bg-card` | `rgba(255,255,255,.05)` | latar card, kotak bahan & langkah |
| `--accent-primary` | `#ff8c42` | oranye: kategori, hover, garis aktif |
| `--accent-secondary` | `#ffd166` | kuning: judul bagian modal, fokus keyboard |
| `--accent-gradient` | oranye → kuning | judul hero, logo, tombol utama, nomor langkah |
| `--text-primary` / `--text-secondary` / `--text-muted` | `#f5f5f5` / `#ccc` / `#a3a3a3` | teks |
| Badge kesulitan | Mudah hijau, Sedang emas, Sulit merah | label di foto (warna + teks) |

## Tipografi
- **Poppins** 300–700 untuk semua teks. Hero 3.5rem, judul bagian 2rem, isi 18px (16px di HP).

## Tata letak
```
┌ Navbar tetap (blur): logo gradien | Beranda Resep Tentang [Cari Resep] ┐
│ Hero (tengah): judul gradien, subjudul, form cari + tombol gradien     │
│ Chip kategori (pil, tengah)                                            │
│ "Semua Resep" (tengah)                                                 │
│ Grid card 3 kolom: foto 3:2 + badge | judul | deskripsi 3 baris | meta │
│ Footer 3 kolom: tentang | tautan cepat | info tugas                    │
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
