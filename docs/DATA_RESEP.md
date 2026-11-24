# Data Resep — Format & Daftar Isi

Data disimpan di `data/resep.json` (array objek). Tanpa database.

## Format Satu Resep

```json
{
  "id": "rendang",
  "nama": "Rendang Daging",
  "daerah": "Sumatera Barat",
  "kategori": "Makanan Berat",
  "waktu": "120 menit",
  "porsi": "12 porsi",
  "kesulitan": "Sedang",
  "warna": "#5A2E1B",
  "gambar": "assets/img/rendang.jpg",
  "deskripsi": "Daging sapi yang dimasak perlahan dalam santan dan bumbu rempah ...",
  "bahan": [
    { "grup": "Bahan utama", "isi": ["1 kg daging sapi", "..."] },
    { "grup": "Bumbu halus", "isi": ["250 g cabai merah besar", "..."] }
  ],
  "langkah": [
    "Potong daging sapi menjadi kubus berukuran sekitar 3 cm ...",
    "..."
  ],
  "tips": [
    "Gunakan daging sapi bagian paha atas ...",
    "..."
  ],
  "sumber_resep": [
    { "nama": "detikFood", "url": "https://food.detik.com/..." }
  ],
  "foto": { "pembuat": "Teguh S", "lisensi": "Lisensi Pexels", "situs": "Pexels", "sumber": "https://www.pexels.com/photo/..." }
}
```

Aturan:
- `id` unik, huruf kecil, pakai tanda hubung (`soto-betawi`).
- `kategori` hanya salah satu dari: **Makanan Berat**, **Sup & Soto**, **Camilan**, **Minuman**.
- `kesulitan`: Mudah / Sedang / Sulit.
- `bahan`: dikelompokkan per `grup` (Bahan utama, Bumbu halus, Pelengkap, ...). Takaran mengikuti sumber resep.
- `langkah`: urutan cara memasak yang rinci (api, waktu, tanda matang). `tips`: catatan dari sumber resep.
- `sumber_resep`: satu atau lebih link resep asli (detikFood / IDN Times).
- `gambar`: path lokal `assets/img/<id>.jpg` (foto landscape 1000×667 dari Pexels / Wikimedia Commons).
- `foto`: pembuat, lisensi, situs, dan link sumber foto (lihat `docs/SUMBER_GAMBAR.md`).
  Jika gambar tidak tersedia, card menampilkan blok warna (`warna`) agar layout tidak rusak.

## Daftar Resep (minimal 12)

| No | id | Nama | Daerah | Kategori |
|---|---|---|---|---|
| 1 | rendang | Rendang Daging | Sumatera Barat | Makanan Berat |
| 2 | nasi-goreng | Nasi Goreng Kampung | Nasional | Makanan Berat |
| 3 | gudeg | Gudeg | Yogyakarta | Makanan Berat |
| 4 | ayam-betutu | Ayam Betutu | Bali | Makanan Berat |
| 5 | coto-makassar | Coto Makassar | Sulawesi Selatan | Sup & Soto |
| 6 | soto-betawi | Soto Betawi | DKI Jakarta | Sup & Soto |
| 7 | rawon | Rawon | Jawa Timur | Sup & Soto |
| 8 | sate-ayam | Sate Ayam Madura | Jawa Timur | Makanan Berat |
| 9 | gado-gado | Gado-Gado | DKI Jakarta | Makanan Berat |
| 10 | pempek | Pempek Kapal Selam | Sumatera Selatan | Camilan |
| 11 | klepon | Klepon | Jawa Tengah | Camilan |
| 12 | es-cendol | Es Cendol | Jawa Barat | Minuman |
| 13 | papeda | Papeda Kuah Kuning | Papua | Makanan Berat |
| 14 | bir-pletok | Bir Pletok | DKI Jakarta | Minuman |
