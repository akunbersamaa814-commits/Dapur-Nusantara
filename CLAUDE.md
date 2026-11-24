# CLAUDE.md — Aturan Projek Dapur Nusantara

Projek tugas kuliah Pemrograman Web: website resep makanan Nusantara.

## Baca dulu
- `docs/PRD.md` — fitur & kriteria selesai
- `docs/SPESIFIKASI_TEKNIS.md` — struktur file, kontrak fungsi PHP & JS
- `docs/DATA_RESEP.md` — format data & daftar resep

## Aturan wajib
- Teknologi hanya **HTML, CSS, JavaScript (vanilla), PHP**. Tanpa framework/library JS,
  tanpa Bootstrap/Tailwind, tanpa database (pakai `data/resep.json`).
- **Detail resep (klik card) → JavaScript.** **Pencarian → PHP** (form GET, filter di server).
  Jangan pindahkan pencarian ke JS.
- Ikuti struktur folder di spesifikasi teknis. Jangan menambah folder/file di luar itu
  tanpa alasan kuat.
- Teks antarmuka dan komentar kode dalam **Bahasa Indonesia**.
- Escape semua output dengan helper `e()`.
- Kode harus mudah dijelaskan mahasiswa saat presentasi: sederhana, berkomentar, tanpa trik berlebihan.
