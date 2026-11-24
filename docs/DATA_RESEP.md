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

## Daftar Resep (95 resep dari 35 provinsi)

Target: satu makanan (Makanan Berat / Sup & Soto), satu camilan, dan satu minuman per provinsi.
Provinsi yang belum lengkap tidak diisi asal-asalan karena belum ditemukan resep khas dengan sumber
yang jelas: NTT, Kalimantan Tengah, Kalimantan Timur, Kalimantan Utara, Sulawesi Tengah, dan
Sulawesi Tenggara (belum ada minuman); Maluku Utara (belum ada camilan); Sulawesi Barat, Papua Barat,
dan Papua Pegunungan (baru ada makanan); Papua Barat Daya, Papua Tengah, dan Papua Selatan (belum ada).

| No | id | Nama | Daerah | Kategori |
|---|---|---|---|---|
| 1 | mie-aceh | Mie Aceh | Aceh | Makanan Berat |
| 2 | timphan | Kue Timphan | Aceh | Camilan |
| 3 | es-timun-serut | Es Timun Serut | Aceh | Minuman |
| 4 | arsik | Arsik Ikan Mas | Sumatera Utara | Makanan Berat |
| 5 | bika-ambon | Bika Ambon | Sumatera Utara | Camilan |
| 6 | teh-susu-telur | Teh Susu Telur | Sumatera Utara | Minuman |
| 7 | rendang | Rendang Daging | Sumatera Barat | Makanan Berat |
| 8 | keripik-balado | Keripik Sanjai Balado | Sumatera Barat | Camilan |
| 9 | teh-talua | Teh Talua | Sumatera Barat | Minuman |
| 10 | gulai-patin | Gulai Ikan Patin | Riau | Makanan Berat |
| 11 | bolu-kemojo | Bolu Kemojo | Riau | Camilan |
| 12 | laksamana-mengamuk | Es Laksamana Mengamuk | Riau | Minuman |
| 13 | mie-lendir | Mie Lendir | Kepulauan Riau | Makanan Berat |
| 14 | otak-otak | Otak-Otak Ikan | Kepulauan Riau | Camilan |
| 15 | teh-obeng | Teh Obeng | Kepulauan Riau | Minuman |
| 16 | tempoyak-patin | Tempoyak Ikan Patin | Jambi | Makanan Berat |
| 17 | padamaran | Kue Padamaran | Jambi | Camilan |
| 18 | aye-kawo | Aye Kawo | Jambi | Minuman |
| 19 | pindang-patin | Pindang Patin | Sumatera Selatan | Sup & Soto |
| 20 | pempek | Pempek Kapal Selam | Sumatera Selatan | Camilan |
| 21 | es-kacang-merah | Es Kacang Merah | Sumatera Selatan | Minuman |
| 22 | pendap | Pendap Ikan | Bengkulu | Makanan Berat |
| 23 | bay-tat | Kue Bay Tat | Bengkulu | Camilan |
| 24 | es-kalamansi | Es Jeruk Kalamansi | Bengkulu | Minuman |
| 25 | seruit | Seruit | Lampung | Makanan Berat |
| 26 | engkak | Engkak Ketan | Lampung | Camilan |
| 27 | serbat-kweni | Serbat Kweni | Lampung | Minuman |
| 28 | lempah-kuning | Lempah Kuning | Kepulauan Bangka Belitung | Sup & Soto |
| 29 | martabak-bangka | Martabak Bangka | Kepulauan Bangka Belitung | Camilan |
| 30 | es-jeruk-kunci | Es Jeruk Kunci | Kepulauan Bangka Belitung | Minuman |
| 31 | soto-betawi | Soto Betawi | DKI Jakarta | Sup & Soto |
| 32 | gado-gado | Gado-Gado | DKI Jakarta | Makanan Berat |
| 33 | kerak-telor | Kerak Telor | DKI Jakarta | Camilan |
| 34 | bir-pletok | Bir Pletok | DKI Jakarta | Minuman |
| 35 | nasi-liwet | Nasi Liwet Sunda | Jawa Barat | Makanan Berat |
| 36 | batagor | Batagor | Jawa Barat | Camilan |
| 37 | es-cendol | Es Cendol | Jawa Barat | Minuman |
| 38 | rabeg | Rabeg Banten | Banten | Makanan Berat |
| 39 | jojorong | Kue Jojorong | Banten | Camilan |
| 40 | es-sekemu | Es Sekemu | Banten | Minuman |
| 41 | garang-asem | Garang Asem Ayam | Jawa Tengah | Sup & Soto |
| 42 | klepon | Klepon | Jawa Tengah | Camilan |
| 43 | wedang-ronde | Wedang Ronde | Jawa Tengah | Minuman |
| 44 | gudeg | Gudeg | Yogyakarta | Makanan Berat |
| 45 | bakpia | Bakpia Kacang Hijau | Yogyakarta | Camilan |
| 46 | wedang-uwuh | Wedang Uwuh | Yogyakarta | Minuman |
| 47 | rawon | Rawon | Jawa Timur | Sup & Soto |
| 48 | sate-ayam | Sate Ayam Madura | Jawa Timur | Makanan Berat |
| 49 | onde-onde | Onde-Onde Wijen | Jawa Timur | Camilan |
| 50 | angsle | Wedang Angsle | Jawa Timur | Minuman |
| 51 | ayam-betutu | Ayam Betutu | Bali | Makanan Berat |
| 52 | laklak | Jaje Laklak | Bali | Camilan |
| 53 | loloh-cemcem | Loloh Cemcem | Bali | Minuman |
| 54 | ayam-taliwang | Ayam Taliwang | Nusa Tenggara Barat | Makanan Berat |
| 55 | cerorot | Cerorot | Nusa Tenggara Barat | Camilan |
| 56 | es-poteng | Es Poteng | Nusa Tenggara Barat | Minuman |
| 57 | sei-sapi | Se'i Sapi | Nusa Tenggara Timur | Makanan Berat |
| 58 | kompiang | Kue Kompiang | Nusa Tenggara Timur | Camilan |
| 59 | bubur-pedas | Bubur Pedas Sambas | Kalimantan Barat | Makanan Berat |
| 60 | choi-pan | Choi Pan | Kalimantan Barat | Camilan |
| 61 | es-lidah-buaya | Es Lidah Buaya | Kalimantan Barat | Minuman |
| 62 | juhu-singkah | Juhu Singkah | Kalimantan Tengah | Sup & Soto |
| 63 | kue-jala | Kue Jala Dayak | Kalimantan Tengah | Camilan |
| 64 | soto-banjar | Soto Banjar | Kalimantan Selatan | Sup & Soto |
| 65 | bingka | Bingka Barandam | Kalimantan Selatan | Camilan |
| 66 | es-buah-banjar | Es Buah Banjarmasin | Kalimantan Selatan | Minuman |
| 67 | nasi-bekepor | Nasi Bekepor | Kalimantan Timur | Makanan Berat |
| 68 | amplang | Amplang | Kalimantan Timur | Camilan |
| 69 | kepiting-soka | Kepiting Soka Asam Manis | Kalimantan Utara | Makanan Berat |
| 70 | lapis-cempedak | Kue Lapis Cempedak | Kalimantan Utara | Camilan |
| 71 | tinutuan | Tinutuan (Bubur Manado) | Sulawesi Utara | Makanan Berat |
| 72 | klappertaart | Klappertaart | Sulawesi Utara | Camilan |
| 73 | es-kacang-tanah | Es Kacang Tanah Manado | Sulawesi Utara | Minuman |
| 74 | binte-biluhuta | Binte Biluhuta | Gorontalo | Sup & Soto |
| 75 | kue-tobuu | Kue Tobu'u | Gorontalo | Camilan |
| 76 | es-brenebon | Es Brenebon | Gorontalo | Minuman |
| 77 | kaledo | Kaledo | Sulawesi Tengah | Sup & Soto |
| 78 | kue-tetu | Kue Tetu | Sulawesi Tengah | Camilan |
| 79 | bau-peapi | Bau Peapi | Sulawesi Barat | Sup & Soto |
| 80 | coto-makassar | Coto Makassar | Sulawesi Selatan | Sup & Soto |
| 81 | barongko | Barongko | Sulawesi Selatan | Camilan |
| 82 | es-pisang-ijo | Es Pisang Ijo | Sulawesi Selatan | Minuman |
| 83 | sinonggi | Sinonggi | Sulawesi Tenggara | Makanan Berat |
| 84 | sanggara-bandang | Sanggara Bandang | Sulawesi Tenggara | Camilan |
| 85 | nasi-lapola | Nasi Lapola | Maluku | Makanan Berat |
| 86 | bagea | Bagea Kenari | Maluku | Camilan |
| 87 | kopi-rarobang | Kopi Rarobang | Maluku | Minuman |
| 88 | gohu-ikan | Gohu Ikan | Maluku Utara | Makanan Berat |
| 89 | air-guraka | Air Guraka | Maluku Utara | Minuman |
| 90 | papeda | Papeda Kuah Kuning | Papua | Makanan Berat |
| 91 | kue-lontar | Kue Lontar | Papua | Camilan |
| 92 | es-matoa | Es Matoa | Papua | Minuman |
| 93 | ikan-bakar-manokwari | Ikan Bakar Manokwari | Papua Barat | Makanan Berat |
| 94 | udang-selingkuh | Udang Selingkuh Bakar | Papua Pegunungan | Makanan Berat |
| 95 | nasi-goreng | Nasi Goreng Kampung | Nasional | Makanan Berat |
