/**
 * script.js — menampilkan detail resep (bahan & cara memasak) saat card diklik,
 * serta membuka/menutup menu navbar di layar kecil.
 * Ditulis dengan JavaScript murni (tanpa library).
 */

// 1. Ambil data resep yang sudah dicetak PHP di halaman.
const dataResep = JSON.parse(document.getElementById('data-resep').textContent);

// 2. Ambil elemen-elemen yang dibutuhkan.
const grid = document.getElementById('grid-resep');
const modal = document.getElementById('modal-resep');
const tombolTutup = modal.querySelector('.modal__tutup');

let tombolTerakhir = null; // tombol card yang terakhir diklik, untuk mengembalikan fokus

/**
 * Membuat elemen baru berisi teks (textContent agar aman dari XSS).
 */
function buatElemen(tag, teks, kelas) {
    const el = document.createElement(tag);
    if (teks) el.textContent = teks;
    if (kelas) el.className = kelas;
    return el;
}

/**
 * Membuat link yang dibuka di tab baru.
 */
function buatLink(teks, url) {
    const a = buatElemen('a', teks);
    a.href = url;
    a.target = '_blank';
    a.rel = 'noopener';
    return a;
}

/**
 * Mengisi daftar bahan per kelompok (Bahan utama, Bumbu halus, Pelengkap, ...).
 */
function isiBahan(wadah, daftarKelompok) {
    wadah.innerHTML = '';
    daftarKelompok.forEach(function (kelompok) {
        wadah.appendChild(buatElemen('h4', kelompok.grup, 'ingredients-group'));
        const ul = buatElemen('ul', '', 'ingredients-list');
        kelompok.isi.forEach(function (bahan) {
            ul.appendChild(buatElemen('li', bahan));
        });
        wadah.appendChild(ul);
    });
}

/**
 * Mengisi sebuah list (<ol>/<ul>) dengan array teks.
 */
function isiList(elemen, daftar) {
    elemen.innerHTML = '';
    daftar.forEach(function (teks) {
        elemen.appendChild(buatElemen('li', teks));
    });
}

/**
 * Membuka modal dan mengisinya dengan data resep berdasarkan id.
 * "pemicu" = tombol yang diklik (dari card atau popup peta), untuk mengembalikan fokus.
 */
function bukaModal(id, pemicu) {
    const resep = dataResep.find(function (r) { return r.id === id; });
    if (!resep) return;
    tombolTerakhir = pemicu;

    // Gambar dan badge tingkat kesulitan.
    // Jika foto belum ada, gambar disembunyikan dan diganti blok warna khas resep.
    const gambar = document.getElementById('modal-gambar');
    gambar.style.display = resep.ada_gambar ? '' : 'none';
    gambar.src = resep.ada_gambar ? resep.gambar : '';
    gambar.alt = resep.nama;
    gambar.parentElement.style.background = resep.warna;
    const badge = document.getElementById('modal-badge');
    badge.textContent = resep.kesulitan;
    badge.className = 'badge badge-' + resep.kesulitan.toLowerCase();

    // Judul, deskripsi, dan info singkat
    document.getElementById('modal-nama').textContent = resep.nama;
    document.getElementById('modal-deskripsi').textContent = resep.deskripsi;
    const meta = document.getElementById('modal-meta');
    meta.innerHTML = '';
    meta.appendChild(buatElemen('span', resep.kategori, 'kategori'));
    meta.appendChild(buatElemen('span', 'Daerah: ' + resep.daerah));
    meta.appendChild(buatElemen('span', 'Waktu: ' + resep.waktu));
    meta.appendChild(buatElemen('span', 'Porsi: ' + resep.porsi));

    // Bahan, langkah, dan tips
    isiBahan(document.getElementById('modal-bahan'), resep.bahan);
    isiList(document.getElementById('modal-langkah'), resep.langkah);
    isiList(document.getElementById('modal-tips'), resep.tips);
    document.getElementById('modal-bagian-tips').hidden = resep.tips.length === 0;

    // Keterangan sumber resep dan foto
    const kredit = document.getElementById('modal-kredit');
    kredit.innerHTML = '';
    kredit.append('Sumber resep: ');
    resep.sumber_resep.forEach(function (sumber, i) {
        if (i > 0) kredit.append(', ');
        kredit.append(buatLink(sumber.nama, sumber.url));
    });
    if (resep.foto) {
        // Foto yang bukan masakan persis diberi keterangan, misalnya "Foto ilustrasi: serabi"
        if (resep.foto.keterangan) kredit.append('. ' + resep.foto.keterangan);
        kredit.append('. Foto: ' + resep.foto.pembuat + ' (' + resep.foto.lisensi + ') via ',
            buatLink(resep.foto.situs, resep.foto.sumber), '.');
    } else {
        kredit.append('. Foto belum tersedia.');
    }

    // Tampilkan modal. showModal() otomatis menangani tombol Esc,
    // dan CSS mengunci scroll halaman selama modal terbuka.
    modal.showModal();
    modal.scrollTop = 0;
    tombolTutup.focus();
}

// 3. Klik card → buka modal. (Event delegation: satu listener untuk semua card.)
//    Karena tombolnya <button> asli, Enter dan Spasi juga memicu event 'click'.
//    Tombol "Lihat di Peta" di card membawa ke peta (lihat bagian 6).
if (grid) {
    grid.addEventListener('click', function (event) {
        const tombolPeta = event.target.closest('.card-peta');
        if (tombolPeta) {
            tampilkanDiPeta(tombolPeta.dataset.daerah);
            return;
        }
        const card = event.target.closest('.recipe-card');
        if (card) {
            const tombol = card.querySelector('.card-buka');
            bukaModal(tombol.dataset.id, tombol);
        }
    });
}

// 4. Cara menutup modal: tombol ✕, klik di luar kotak (backdrop), atau tombol Esc.
tombolTutup.addEventListener('click', function () {
    modal.close();
});

modal.addEventListener('click', function (event) {
    // Jika yang diklik adalah <dialog> itu sendiri (area gelap di luar kotak), tutup.
    if (event.target === modal) modal.close();
});

// Event 'close' terpanggil untuk semua cara menutup (termasuk Esc).
modal.addEventListener('close', function () {
    // kembalikan fokus ke tombol pemicu (card atau popup peta) jika masih ada di halaman
    if (tombolTerakhir && tombolTerakhir.isConnected) tombolTerakhir.focus();
});

// 5. Menu navbar di layar kecil: tombol hamburger membuka/menutup daftar link.
const hamburger = document.querySelector('.hamburger');
const navLinks = document.getElementById('nav-links');

hamburger.addEventListener('click', function () {
    const terbuka = navLinks.classList.toggle('active');
    hamburger.setAttribute('aria-expanded', terbuka);
    hamburger.setAttribute('aria-label', terbuka ? 'Tutup menu' : 'Buka menu');
});

// Tutup menu setelah salah satu link diklik.
navLinks.addEventListener('click', function (event) {
    if (event.target.closest('a')) {
        navLinks.classList.remove('active');
        hamburger.setAttribute('aria-expanded', 'false');
        hamburger.setAttribute('aria-label', 'Buka menu');
    }
});

// 6. Peta Daerah (JavaScript murni, tanpa library).
//    Gambar peta SVG + penanda daerah sudah dibuat oleh PHP. JavaScript mengatur:
//    - popup berisi masakan dari daerah yang diklik (tombol "Lihat Resep" → modal resep),
//    - zoom sederhana (tombol +, −, reset),
//    - tombol "Lihat di Peta" di card.
const petaArea = document.getElementById('peta-area');
const petaLapisan = document.getElementById('peta-lapisan');
const popup = document.getElementById('peta-popup');
const popupIsi = document.getElementById('peta-popup-isi');
const popupTutup = popup.querySelector('.peta-popup__tutup');
const petaPanel = document.getElementById('peta-panel');
const LEBAR_SEMPIT = 560;                  // di bawah lebar ini, popup tampil sebagai panel di bawah peta
const tombolZoom = document.querySelectorAll('.peta-zoom button');

const RASIO_PETA = 1200 / 459.5;           // lebar : tinggi gambar peta
const TINGKAT_ZOOM = [1, 1.5, 2, 3, 4];    // pilihan perbesaran
let indeksZoom = 0;
let penandaAktif = null;                   // penanda yang popup-nya sedang terbuka
let pusatPandang = { x: 0.5, y: 0.5 };     // titik tengah peta yang sedang dilihat (pecahan 0–1)

/**
 * Membuat isi popup: kartu untuk setiap masakan dari satu daerah.
 * Dibuat dengan createElement + textContent agar aman dari XSS.
 */
function buatIsiPopup(daerah, daftarResep) {
    const wadah = buatElemen('div', '', 'popup-daftar');

    daftarResep.forEach(function (resep) {
        const kartu = buatElemen('article', '', 'popup-kartu');

        // Foto + label daerah + kredit foto
        const gambar = buatElemen('div', '', 'popup-gambar');
        gambar.style.background = resep.warna; // terlihat jika foto belum ada
        if (resep.ada_gambar) {
            const img = document.createElement('img');
            img.src = resep.gambar;
            img.alt = resep.nama;
            gambar.appendChild(img);
        }
        gambar.appendChild(buatElemen('span', daerah, 'popup-daerah'));
        if (resep.foto) {
            const kredit = buatLink('Foto: ' + resep.foto.situs, resep.foto.sumber);
            kredit.className = 'popup-kredit';
            gambar.appendChild(kredit);
        }

        // Nama (dengan ikon pin), deskripsi singkat, dan tombol lihat resep
        const isi = buatElemen('div', '', 'popup-isi');
        const judul = buatElemen('h3', '', 'popup-judul');
        judul.innerHTML = '<svg aria-hidden="true" viewBox="0 0 24 24"><path d="M20 10c0 5-5.5 10.2-7.4 11.8a1 1 0 0 1-1.2 0C9.5 20.2 4 15 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/></svg>';
        judul.append(resep.nama);
        isi.appendChild(judul);
        isi.appendChild(buatElemen('p', resep.deskripsi, 'popup-desk'));
        const tombol = buatElemen('button', 'Lihat Resep', 'btn btn-primary popup-tombol');
        tombol.type = 'button';
        tombol.addEventListener('click', function () {
            bukaModal(resep.id, tombol);
        });
        isi.appendChild(tombol);

        kartu.append(gambar, isi);
        wadah.appendChild(kartu);
    });

    return wadah;
}

/**
 * Menaruh popup di dekat penanda aktif, dengan urutan pilihan:
 * 1) di atas penanda, 2) di bawah penanda, 3) di samping penanda (kanan/kiri)
 * — dipilih yang muat di bagian peta yang sedang terlihat, agar penanda tidak tertutup.
 */
function posisikanPopup() {
    if (!penandaAktif) return;

    // Layar sempit (HP): popup menjadi panel di bawah peta, tidak perlu dihitung posisinya.
    const sempit = petaArea.clientWidth < LEBAR_SEMPIT;
    const tempat = sempit ? petaPanel : petaLapisan;
    if (popup.parentElement !== tempat) tempat.appendChild(popup);
    popup.classList.toggle('panel', sempit);
    if (sempit) {
        popup.style.left = '';
        popup.style.top = '';
        delete popup.dataset.arah;
        return;
    }

    const TINGGI_PENANDA = 26;
    const JARAK = 10;
    const RUANG_CARI = 76; // ruang di atas peta yang tertutup kotak cari

    // Posisi ujung bawah penanda di dalam lapisan peta (piksel)
    const x = parseFloat(penandaAktif.style.left) / 100 * petaLapisan.offsetWidth;
    const y = parseFloat(penandaAktif.style.top) / 100 * petaLapisan.offsetHeight;
    const lebar = popup.offsetWidth;
    const tinggi = popup.offsetHeight;

    // Bagian peta yang sedang terlihat (ikut posisi scroll)
    const kiriTerlihat = petaArea.scrollLeft + 8;
    const atasTerlihat = petaArea.scrollTop + 8;
    const kananTerlihat = petaArea.scrollLeft + petaArea.clientWidth - 8;
    const bawahTerlihat = petaArea.scrollTop + petaArea.clientHeight - 8;
    const batasi = function (nilai, min, maks) { return Math.max(min, Math.min(nilai, maks)); };

    let kiri, atas, arah;
    if (y - TINGGI_PENANDA - JARAK - tinggi >= atasTerlihat + RUANG_CARI) {
        arah = 'atas';
        atas = y - TINGGI_PENANDA - JARAK - tinggi;
    } else if (y + JARAK + tinggi <= bawahTerlihat) {
        arah = 'bawah';
        atas = y + JARAK;
    } else {
        // Tidak muat di atas/bawah: taruh di samping, sejajar dengan tengah penanda
        arah = (x + 24 + JARAK + lebar <= kananTerlihat) ? 'kanan' : 'kiri';
        kiri = (arah === 'kanan') ? x + 24 + JARAK : x - 24 - JARAK - lebar;
        atas = batasi(y - TINGGI_PENANDA / 2 - tinggi / 2, atasTerlihat, bawahTerlihat - tinggi);
    }
    if (arah === 'atas' || arah === 'bawah') {
        kiri = batasi(x - lebar / 2, kiriTerlihat, kananTerlihat - lebar);
    }

    popup.style.left = kiri + 'px';
    popup.style.top = atas + 'px';
    popup.dataset.arah = arah; // dipakai CSS untuk arah panah
    popup.style.setProperty('--panah-x', batasi(x - kiri, 16, lebar - 16) + 'px');
    popup.style.setProperty('--panah-y', batasi(y - TINGGI_PENANDA / 2 - atas, 16, tinggi - 16) + 'px');
}

/**
 * Membuka popup untuk sebuah penanda daerah.
 */
function bukaPopup(penanda) {
    const daerah = penanda.dataset.daerah;
    const daftarResep = dataResep.filter(function (r) { return r.daerah === daerah; });

    if (penandaAktif) penandaAktif.setAttribute('aria-expanded', 'false');
    penandaAktif = penanda;
    penanda.setAttribute('aria-expanded', 'true');

    popupIsi.replaceChildren(buatIsiPopup(daerah, daftarResep));
    popup.setAttribute('aria-label', 'Masakan dari ' + daerah);
    popup.hidden = false;
    posisikanPopup();
    popupTutup.focus({ preventScroll: true }); // fokus pindah ke popup (untuk pengguna keyboard)

    // Di layar sempit, geser peta agar penanda di tengah, lalu tampilkan panel di bawah peta.
    if (popup.classList.contains('panel')) {
        petaArea.scrollLeft = parseFloat(penanda.style.left) / 100 * petaLapisan.offsetWidth - petaArea.clientWidth / 2;
        popup.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
}

/**
 * Menutup popup. Jika kembalikanFokus = true, fokus kembali ke penandanya.
 */
function tutupPopup(kembalikanFokus) {
    if (!penandaAktif) return;
    popup.hidden = true;
    penandaAktif.setAttribute('aria-expanded', 'false');
    if (kembalikanFokus) penandaAktif.focus({ preventScroll: true });
    penandaAktif = null;
}

/**
 * Menyimpan titik tengah yang sedang dilihat (dipakai saat ukuran layar berubah).
 */
function simpanPusatPandang() {
    pusatPandang = {
        x: (petaArea.scrollLeft + petaArea.clientWidth / 2) / petaLapisan.offsetWidth,
        y: (petaArea.scrollTop + petaArea.clientHeight / 2) / petaLapisan.offsetHeight
    };
}

/**
 * Zoom sederhana: lebar lapisan peta = lebar dasar × tingkat zoom.
 * Penanda ikut bergeser karena posisinya dalam persen. Titik tengah yang
 * sedang dilihat dijaga tetap di tengah (atau memakai "tengah" jika diberikan,
 * dalam pecahan 0–1 dari lebar/tinggi peta).
 */
function aturZoom(indeksBaru, tengah) {
    indeksZoom = Math.max(0, Math.min(indeksBaru, TINGKAT_ZOOM.length - 1));

    const lebarLama = petaLapisan.offsetWidth;
    const tinggiLama = petaLapisan.offsetHeight;
    const titik = tengah || {
        x: (petaArea.scrollLeft + petaArea.clientWidth / 2) / lebarLama,
        y: (petaArea.scrollTop + petaArea.clientHeight / 2) / tinggiLama
    };

    // Lebar dasar: peta memenuhi lebar area, atau memenuhi tingginya di layar sempit (HP).
    // offsetWidth/offsetHeight dipakai karena tidak berubah oleh munculnya scrollbar.
    const lebarDasar = Math.max(petaArea.offsetWidth, petaArea.offsetHeight * RASIO_PETA);
    const lebarBaru = lebarDasar * TINGKAT_ZOOM[indeksZoom];
    petaLapisan.style.width = lebarBaru + 'px';

    // Jika peta pas di dalam area (zoom 1 di layar lebar), sembunyikan scrollbar.
    petaArea.classList.toggle('pas', lebarBaru <= petaArea.offsetWidth + 1);

    petaArea.scrollLeft = titik.x * lebarBaru - petaArea.clientWidth / 2;
    petaArea.scrollTop = titik.y * (lebarBaru / RASIO_PETA) - petaArea.clientHeight / 2;
    simpanPusatPandang();

    // Matikan tombol yang sudah di batas
    tombolZoom.forEach(function (tombol) {
        const jenis = tombol.dataset.zoom;
        tombol.disabled = (jenis === 'masuk' && indeksZoom === TINGKAT_ZOOM.length - 1) ||
                          (jenis !== 'masuk' && indeksZoom === 0);
    });

    posisikanPopup();
}

/**
 * Dari tombol "Lihat di Peta" di card: gulir ke peta, perbesar ke daerahnya, lalu buka popup.
 */
function tampilkanDiPeta(daerah) {
    const penanda = petaLapisan.querySelector('.penanda[data-daerah="' + CSS.escape(daerah) + '"]');
    if (!penanda) return;
    document.getElementById('peta').scrollIntoView({ behavior: 'smooth' });
    aturZoom(2, {
        x: parseFloat(penanda.style.left) / 100,
        y: parseFloat(penanda.style.top) / 100
    });
    bukaPopup(penanda);
}

// Klik penanda → buka popup (klik lagi → tutup). Klik area kosong peta → tutup popup.
petaArea.addEventListener('click', function (event) {
    const penanda = event.target.closest('.penanda');
    if (penanda) {
        if (penanda === penandaAktif) tutupPopup(true);
        else bukaPopup(penanda);
        return;
    }
    if (!event.target.closest('.peta-popup')) tutupPopup(false);
});

popupTutup.addEventListener('click', function () {
    tutupPopup(true);
});

// Tombol Esc menutup popup (kecuali saat modal resep sedang terbuka).
document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape' && !modal.open) tutupPopup(true);
});

// Tombol zoom +, −, dan reset.
// Jika ada popup terbuka, zoom berpusat di penandanya agar penanda & popup tetap terlihat.
tombolZoom.forEach(function (tombol) {
    tombol.addEventListener('click', function () {
        const tengah = penandaAktif ? {
            x: parseFloat(penandaAktif.style.left) / 100,
            y: parseFloat(penandaAktif.style.top) / 100
        } : undefined;
        if (tombol.dataset.zoom === 'masuk') aturZoom(indeksZoom + 1, tengah);
        else if (tombol.dataset.zoom === 'keluar') aturZoom(indeksZoom - 1, tengah);
        else aturZoom(0, { x: 0.5, y: 0.5 });
    });
});

// Simpan titik tengah setiap kali peta digeser (scroll).
petaArea.addEventListener('scroll', simpanPusatPandang);

// Saat ukuran layar berubah, hitung ulang ukuran peta dengan titik tengah yang sama.
window.addEventListener('resize', function () {
    aturZoom(indeksZoom, pusatPandang);
});

// Ukuran awal: zoom 1, pusat peta di tengah.
aturZoom(0, { x: 0.5, y: 0.5 });
