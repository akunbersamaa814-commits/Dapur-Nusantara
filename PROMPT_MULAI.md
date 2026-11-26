# Prompt Mulai Projek

Salin seluruh isi blok di bawah ini ke Dapur Nusantara (di folder `projek_pemweb`) untuk membangun
website sekali jalan.

---

```text
Bangun website "Dapur Nusantara" (resep makanan Nusantara) sampai selesai dan bisa dijalankan,
dalam satu sesi ini.

LANGKAH 0 — Baca konteks
Baca CLAUDE.md, docs/PRD.md, docs/SPESIFIKASI_TEKNIS.md, dan docs/DATA_RESEP.md.
Semua aturan di dokumen itu wajib diikuti (HTML + CSS + vanilla JS + PHP, tanpa framework,
tanpa database; detail resep via JS, pencarian via PHP).

LANGKAH 1 — Arah desain (gunakan skill)
1. Jalankan /ui-ux-pro-max untuk menentukan: gaya visual, palet warna, pasangan font,
   pola layout card + modal, dan pedoman UX/aksesibilitas yang cocok untuk website resep
   makanan tradisional Indonesia (nuansa hangat, rempah, rumahan).
2. Jalankan /frontend-design untuk membuat arah visual yang khas dan tidak terlihat seperti
   template generik (tipografi berkarakter, aksen motif/ornamen Nusantara yang halus,
   hierarki yang jelas).
Rangkum keputusan desain singkat ke file docs/DESAIN.md (palet sebagai CSS variables,
font, radius, shadow, spacing) sebelum menulis kode.
Catatan: hasil skill diterapkan dengan CSS murni (bukan Tailwind/shadcn).

LANGKAH 2 — Data
Buat data/resep.json berisi semua resep di docs/DATA_RESEP.md (minimal 12) dengan bahan dan
langkah yang benar dan realistis. Untuk gambar, pakai placeholder yang rapi bila tidak ada
file gambar (jangan sampai layout rusak).

LANGKAH 3 — Kode
Buat file sesuai struktur di docs/SPESIFIKASI_TEKNIS.md:
- includes/data.php, includes/header.php, includes/footer.php, includes/card.php
- index.php
- assets/css/style.css (mobile-first, responsif, fokus terlihat, prefers-reduced-motion)
- assets/js/script.js (modal detail: klik/Enter/Space buka; ✕/backdrop/Escape tutup;
  kunci scroll; kembalikan fokus)
Komentar kode dan teks UI dalam Bahasa Indonesia. Hapus file .gitkeep di folder yang sudah terisi.

LANGKAH 4 — Verifikasi
Jalankan `php -S localhost:8000` (jika PHP belum ada, beri tahu saya cara memasangnya) lalu
buka di browser bawaan dan cek:
- semua card tampil; klik card → modal bahan & langkah benar; modal bisa ditutup 3 cara
- ?q=rendang, ?q=santan (cari bahan), ?q=xyz (hasil kosong), ?kategori=Minuman
- tampilan di lebar HP (375px) dan desktop
- tidak ada error di console maupun warning PHP
Perbaiki semua masalah yang ditemukan.

LANGKAH 5 — Rapikan
Jalankan /simplify pada kode yang dibuat, lalu centang checklist "Kriteria Selesai"
di docs/PRD.md yang sudah terpenuhi. Akhiri dengan ringkasan file yang dibuat dan
cara menjalankan website.
```

---

## Skill yang dipakai

| Skill | Kegunaan |
|---|---|
| `/ui-ux-pro-max` | Pilih gaya, palet warna, font, pola UX card & modal, aksesibilitas |
| `/frontend-design` | Arah visual yang khas, tidak generik |
| `/simplify` | Merapikan kode setelah selesai agar mudah dijelaskan saat presentasi |
| Browser bawaan Dapur Nusantara | Mengecek website langsung setelah dibuat |
