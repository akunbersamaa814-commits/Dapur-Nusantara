<?php /* header.php — bagian <head>, link lewati, dan navbar. */ ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dapur Nusantara — Resep Masakan Khas Nusantara</title>
    <meta name="description" content="Kumpulan resep masakan khas Nusantara lengkap dengan bahan dan cara memasak.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<a class="lewati" href="#daftar-resep">Lewati ke daftar resep</a>

<!-- Navbar tetap di atas (transparan dengan efek blur) -->
<nav class="navbar" aria-label="Navigasi utama">
    <a class="nav-brand" href="./">
        <svg class="nav-brand__ikon" aria-hidden="true" viewBox="0 0 24 24">
            <path d="M3 11h18a9 9 0 0 1-18 0z"/><path d="M8 7c0-1.5 1-2 1-3.5M12 7c0-1.5 1-2 1-3.5M16 7c0-1.5 1-2 1-3.5"/>
        </svg>
        <span>Dapur Nusantara</span>
    </a>

    <!-- Tombol menu untuk layar kecil (dibuka/tutup oleh JavaScript) -->
    <button class="hamburger" type="button" aria-label="Buka menu" aria-expanded="false" aria-controls="nav-links">
        <span></span><span></span><span></span>
    </button>

    <div class="nav-links" id="nav-links">
        <a href="./">Beranda</a>
        <a href="#daftar-resep">Resep</a>
        <a href="#peta">Peta Daerah</a>
        <a href="#tentang">Tentang</a>
        <a class="btn btn-primary btn-sm" href="#cari">Cari Resep</a>
    </div>
</nav>
