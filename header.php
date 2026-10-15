<?php
// Variabel opsional dari halaman: $judulHalaman, $halamanAktif
$judulHalaman = $judulHalaman ?? 'Kantin Kampus';
$halamanAktif = $halamanAktif ?? '';
$jumlahItem   = jumlah_item_keranjang($_SESSION['keranjang']);
$flash        = ambil_flash(); // hanya tampil sekali
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($judulHalaman) ?> | Kantin Kampus</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<header class="site-header">
    <div class="container header-inner">
        <a class="brand" href="index.php">Kantin Kampus</a>
        <nav class="nav">
            <a href="index.php" class="<?= $halamanAktif === 'menu' ? 'aktif' : '' ?>">Daftar Menu</a>
            <a href="keranjang.php" class="<?= $halamanAktif === 'keranjang' ? 'aktif' : '' ?>">
                Keranjang <span class="badge"><?= $jumlahItem ?></span>
            </a>
        </nav>
    </div>
</header>

<main class="container">
<?php if ($flash): ?>
    <div class="flash flash-<?= e($flash['tipe']) ?>" role="alert">
        <?= e($flash['pesan']) ?>
    </div>
<?php endif; ?>
