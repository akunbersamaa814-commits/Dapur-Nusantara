# Data Resep — Format & Daftar Isi

Data disimpan di `data/resep.json` (array objek). Tanpa database.

## Format Satu Resep

```json
{
  "id": "rendang",
  "nama": "Rendang Daging",
  "daerah": "Sumatera Barat",
  "kategori": "Makanan Berat",
  "waktu": "120 menit (2 jam)",
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
- `waktu`: selalu dalam menit; jika 60 menit atau lebih, ditambah keterangan jam, mis. `45 menit`, `75 menit (1 jam 15 menit)`, `120 menit (2 jam)`.
- `bahan`: dikelompokkan per `grup` (Bahan utama, Bumbu halus, Pelengkap, ...). Takaran mengikuti sumber resep.
- `langkah`: urutan cara memasak yang rinci (api, waktu, tanda matang). `tips`: catatan dari sumber resep.
- `sumber_resep`: satu atau lebih link resep asli (detikFood / IDN Times).
- `gambar`: path lokal `assets/img/<id>.jpg` (foto landscape 1000×667 dari Pexels / Wikimedia Commons).
- `foto`: pembuat, lisensi, situs, dan link sumber foto (lihat `docs/SUMBER_GAMBAR.md`).
  Jika gambar tidak tersedia, card menampilkan blok warna (`warna`) agar layout tidak rusak.

## Daftar Resep (89 resep dari 35 provinsi)

Target: satu makanan (Makanan Berat / Sup & Soto), satu camilan, dan satu minuman per provinsi.
Provinsi yang belum lengkap tidak diisi asal-asalan karena belum ditemukan resep khas dengan sumber
yang jelas: Aceh dan NTB (belum ada camilan); Sulawesi Utara, Kalimantan Tengah, Kalimantan Timur,
Kalimantan Utara, Sulawesi Tengah, dan Sulawesi Tenggara (belum ada minuman); NTT (baru ada makanan);
Maluku Utara, Sulawesi Barat, Papua Barat, dan Papua Pegunungan (baru ada makanan);
Papua Barat Daya, Papua Tengah, dan Papua Selatan (belum ada).

| No | id | Nama | Daerah | Kategori |
|---|---|---|---|---|
| 1 | mie-aceh | Mie Aceh | Aceh | Makanan Berat |
| 2 | es-timun-serut | Es Timun Serut | Aceh | Minuman |
| 3 | arsik | Arsik Ikan Mas | Sumatera Utara | Makanan Berat |
| 4 | bika-ambon | Bika Ambon | Sumatera Utara | Camilan |
| 5 | teh-susu-telur | Teh Susu Telur | Sumatera Utara | Minuman |
| 6 | rendang | Rendang Daging | Sumatera Barat | Makanan Berat |
| 7 | keripik-balado | Keripik Sanjai Balado | Sumatera Barat | Camilan |
| 8 | teh-talua | Teh Talua | Sumatera Barat | Minuman |
| 9 | gulai-patin | Gulai Ikan Patin | Riau | Makanan Berat |
| 10 | bolu-kemojo | Bolu Kemojo | Riau | Camilan |
| 11 | laksamana-mengamuk | Es Laksamana Mengamuk | Riau | Minuman |
| 12 | mie-lendir | Mie Lendir | Kepulauan Riau | Makanan Berat |
| 13 | otak-otak | Otak-Otak Ikan | Kepulauan Riau | Camilan |
| 14 | teh-obeng | Teh Obeng | Kepulauan Riau | Minuman |
| 15 | tempoyak-patin | Tempoyak Ikan Patin | Jambi | Makanan Berat |
| 16 | padamaran | Kue Padamaran | Jambi | Camilan |
| 17 | aye-kawo | Aye Kawo | Jambi | Minuman |
| 18 | pindang-patin | Pindang Patin | Sumatera Selatan | Sup & Soto |
| 19 | pempek | Pempek Kapal Selam | Sumatera Selatan | Camilan |
| 20 | es-kacang-merah | Es Kacang Merah | Sumatera Selatan | Minuman |
| 21 | pendap | Pendap Ikan | Bengkulu | Makanan Berat |
| 22 | bay-tat | Kue Bay Tat | Bengkulu | Camilan |
| 23 | es-kalamansi | Es Jeruk Kalamansi | Bengkulu | Minuman |
| 24 | seruit | Seruit | Lampung | Makanan Berat |
| 25 | engkak | Engkak Ketan | Lampung | Camilan |
| 26 | serbat-kweni | Serbat Kweni | Lampung | Minuman |
| 27 | lempah-kuning | Lempah Kuning | Kepulauan Bangka Belitung | Sup & Soto |
| 28 | martabak-bangka | Martabak Bangka | Kepulauan Bangka Belitung | Camilan |
| 29 | es-jeruk-kunci | Es Jeruk Kunci | Kepulauan Bangka Belitung | Minuman |
| 30 | soto-betawi | Soto Betawi | DKI Jakarta | Sup & Soto |
| 31 | gado-gado | Gado-Gado | DKI Jakarta | Makanan Berat |
| 32 | kerak-telor | Kerak Telor | DKI Jakarta | Camilan |
| 33 | bir-pletok | Bir Pletok | DKI Jakarta | Minuman |
| 34 | nasi-liwet | Nasi Liwet Sunda | Jawa Barat | Makanan Berat |
| 35 | batagor | Batagor | Jawa Barat | Camilan |
| 36 | es-cendol | Es Cendol | Jawa Barat | Minuman |
| 37 | rabeg | Rabeg Banten | Banten | Makanan Berat |
| 38 | jojorong | Kue Jojorong | Banten | Camilan |
| 39 | es-sekemu | Es Sekemu | Banten | Minuman |
| 40 | garang-asem | Garang Asem Ayam | Jawa Tengah | Sup & Soto |
| 41 | klepon | Klepon | Jawa Tengah | Camilan |
| 42 | wedang-ronde | Wedang Ronde | Jawa Tengah | Minuman |
| 43 | gudeg | Gudeg | Yogyakarta | Makanan Berat |
| 44 | bakpia | Bakpia Kacang Hijau | Yogyakarta | Camilan |
| 45 | wedang-uwuh | Wedang Uwuh | Yogyakarta | Minuman |
| 46 | rawon | Rawon | Jawa Timur | Sup & Soto |
| 47 | sate-ayam | Sate Ayam Madura | Jawa Timur | Makanan Berat |
| 48 | onde-onde | Onde-Onde Wijen | Jawa Timur | Camilan |
| 49 | angsle | Wedang Angsle | Jawa Timur | Minuman |
| 50 | ayam-betutu | Ayam Betutu | Bali | Makanan Berat |
| 51 | laklak | Jaje Laklak | Bali | Camilan |
| 52 | loloh-cemcem | Loloh Cemcem | Bali | Minuman |
| 53 | ayam-taliwang | Ayam Taliwang | Nusa Tenggara Barat | Makanan Berat |
| 54 | es-poteng | Es Poteng | Nusa Tenggara Barat | Minuman |
| 55 | sei-sapi | Se'i Sapi | Nusa Tenggara Timur | Makanan Berat |
| 56 | bubur-pedas | Bubur Pedas Sambas | Kalimantan Barat | Makanan Berat |
| 57 | choi-pan | Choi Pan | Kalimantan Barat | Camilan |
| 58 | es-lidah-buaya | Es Lidah Buaya | Kalimantan Barat | Minuman |
| 59 | juhu-singkah | Juhu Singkah | Kalimantan Tengah | Sup & Soto |
| 60 | kue-jala | Kue Jala Dayak | Kalimantan Tengah | Camilan |
| 61 | soto-banjar | Soto Banjar | Kalimantan Selatan | Sup & Soto |
| 62 | bingka | Bingka Barandam | Kalimantan Selatan | Camilan |
| 63 | es-buah-banjar | Es Buah Banjarmasin | Kalimantan Selatan | Minuman |
| 64 | nasi-bekepor | Nasi Bekepor | Kalimantan Timur | Makanan Berat |
| 65 | amplang | Amplang | Kalimantan Timur | Camilan |
| 66 | kepiting-soka | Kepiting Soka Asam Manis | Kalimantan Utara | Makanan Berat |
| 67 | lapis-cempedak | Kue Lapis Cempedak | Kalimantan Utara | Camilan |
| 68 | tinutuan | Tinutuan (Bubur Manado) | Sulawesi Utara | Makanan Berat |
| 69 | klappertaart | Klappertaart | Sulawesi Utara | Camilan |
| 70 | binte-biluhuta | Binte Biluhuta | Gorontalo | Sup & Soto |
| 71 | kue-tobuu | Kue Tobu'u | Gorontalo | Camilan |
| 72 | es-brenebon | Es Brenebon | Gorontalo | Minuman |
| 73 | kaledo | Kaledo | Sulawesi Tengah | Sup & Soto |
| 74 | kue-tetu | Kue Tetu | Sulawesi Tengah | Camilan |
| 75 | bau-peapi | Bau Peapi | Sulawesi Barat | Sup & Soto |
| 76 | coto-makassar | Coto Makassar | Sulawesi Selatan | Sup & Soto |
| 77 | barongko | Barongko | Sulawesi Selatan | Camilan |
| 78 | es-pisang-ijo | Es Pisang Ijo | Sulawesi Selatan | Minuman |
| 79 | sinonggi | Sinonggi | Sulawesi Tenggara | Makanan Berat |
| 80 | sanggara-bandang | Sanggara Bandang | Sulawesi Tenggara | Camilan |
| 81 | nasi-lapola | Nasi Lapola | Maluku | Makanan Berat |
| 82 | bagea | Bagea Kenari | Maluku | Camilan |
| 83 | kopi-rarobang | Kopi Rarobang | Maluku | Minuman |
| 84 | gohu-ikan | Gohu Ikan | Maluku Utara | Makanan Berat |
| 85 | papeda | Papeda Kuah Kuning | Papua | Makanan Berat |
| 86 | kue-lontar | Kue Lontar | Papua | Camilan |
| 87 | es-matoa | Es Matoa | Papua | Minuman |
| 88 | ikan-bakar-manokwari | Ikan Bakar Manokwari | Papua Barat | Makanan Berat |
| 89 | udang-selingkuh | Udang Selingkuh Bakar | Papua Pegunungan | Makanan Berat |
