<?php
/**
 * Pemroses semua aksi POST.
 * Pola Post/Redirect/Get: setiap aksi diakhiri redirect, hasilnya lewat flash message.
 */
$menu = require __DIR__ . '/data/menu.php';
require __DIR__ . '/includes/fungsi.php';

// Hanya menerima POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('index.php');
}

$aksi    = (isset($_POST['aksi']) && is_string($_POST['aksi'])) ? $_POST['aksi'] : '';
$halaman = (isset($_POST['halaman']) && is_string($_POST['halaman'])) ? $_POST['halaman'] : 'index.php';
if (!in_array($halaman, ['index.php', 'keranjang.php'], true)) {
    $halaman = 'index.php'; // whitelist tujuan redirect
}

$kode = (isset($_POST['kode']) && is_string($_POST['kode'])) ? trim($_POST['kode']) : '';

switch ($aksi) {

    // ---------- Tambah pesanan ----------
    case 'tambah':
        // 1. Validasi kode menu (harus terdaftar di array server)
        if ($kode === '' || !isset($menu[$kode])) {
            set_flash('error', 'Kode menu tidak terdaftar. Pesanan ditolak.');
            redirect($halaman);
        }

        // 2. Validasi jumlah
        $cek = validasi_jumlah($_POST['jumlah'] ?? null);
        if (!$cek['valid']) {
            set_flash('error', $cek['pesan'] . ' Keranjang tidak diubah.');
            redirect($halaman);
        }

        // 3. Gabungkan jumlah, batas total 10 per menu
        $sudahAda   = (int) ($_SESSION['keranjang'][$kode] ?? 0);
        $jumlahBaru = $sudahAda + $cek['nilai'];

        if ($jumlahBaru > MAKS_JUMLAH) {
            set_flash('error', sprintf(
                'Penambahan ditolak: jumlah %s di keranjang sudah %d, ditambah %d menjadi %d (maksimal %d). Isi keranjang tidak diubah.',
                $menu[$kode]['nama'], $sudahAda, $cek['nilai'], $jumlahBaru, MAKS_JUMLAH
            ));
            redirect($halaman);
        }

        $_SESSION['keranjang'][$kode] = $jumlahBaru;
        set_flash('sukses', sprintf(
            '%d x %s berhasil ditambahkan. Jumlah di keranjang sekarang: %d.',
            $cek['nilai'], $menu[$kode]['nama'], $jumlahBaru
        ));
        redirect($halaman);
        break;

    // ---------- Hapus satu item ----------
    case 'hapus':
        if ($kode !== '' && isset($_SESSION['keranjang'][$kode])) {
            $nama = $menu[$kode]['nama'] ?? $kode;
            unset($_SESSION['keranjang'][$kode]);
            set_flash('sukses', 'Item "' . $nama . '" dihapus dari keranjang.');
        } else {
            set_flash('error', 'Item tidak ditemukan di keranjang.');
        }
        redirect('keranjang.php');
        break;

    // ---------- Kosongkan keranjang ----------
    case 'kosongkan':
        if (count($_SESSION['keranjang']) === 0) {
            set_flash('info', 'Keranjang sudah kosong.');
        } else {
            $_SESSION['keranjang'] = [];
            set_flash('sukses', 'Keranjang berhasil dikosongkan.');
        }
        redirect('keranjang.php');
        break;

    // ---------- Simpan kategori favorit (cookie 7 hari) ----------
    case 'simpan_kategori':
        $pilihan  = array_merge(['Semua'], daftar_kategori($menu));
        $kategori = $_POST['kategori_favorit'] ?? null;

        if (!kategori_valid($kategori, $pilihan)) {
            set_flash('error', 'Kategori favorit tidak valid.');
            redirect('index.php');
        }

        setcookie(COOKIE_KATEGORI, $kategori, [
            'expires'  => time() + MASA_COOKIE,
            'path'     => '/',
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
        set_flash('sukses', 'Kategori favorit disimpan: ' . $kategori . ' (berlaku 7 hari).');
        redirect('index.php');
        break;

    default:
        set_flash('error', 'Aksi tidak dikenal.');
        redirect('index.php');
}
