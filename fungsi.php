<?php
/**
 * Fungsi-fungsi pembantu aplikasi Kantin Kampus.
 * File ini juga memulai session dan menyiapkan keranjang.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ---------- Konstanta ----------
const MAKS_JUMLAH     = 10;
const MIN_DISKON      = 50000;            // subtotal minimal untuk diskon
const PERSEN_DISKON   = 10;               // persen diskon
const COOKIE_KATEGORI = 'kategori_favorit';
const MASA_COOKIE     = 7 * 24 * 60 * 60; // 7 hari (detik)

// ---------- Inisialisasi keranjang ----------
if (!isset($_SESSION['keranjang']) || !is_array($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = []; // format: ['M01' => jumlah]
}

// ---------- Helper tampilan ----------
function e($teks): string
{
    return htmlspecialchars((string) $teks, ENT_QUOTES, 'UTF-8');
}

function rupiah(int $angka): string
{
    return 'Rp' . number_format($angka, 0, ',', '.');
}

function redirect(string $url): void
{
    header('Location: ' . $url);
    exit;
}

// ---------- Flash message (tampil sekali) ----------
function set_flash(string $tipe, string $pesan): void
{
    $_SESSION['flash'] = ['tipe' => $tipe, 'pesan' => $pesan];
}

function ambil_flash(): ?array
{
    if (!isset($_SESSION['flash'])) {
        return null;
    }
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']); // hapus agar hanya tampil sekali
    return $flash;
}

// ---------- Validasi ----------
/**
 * Validasi jumlah: harus bilangan bulat 1-10.
 * @return array ['valid' => bool, 'nilai' => int, 'pesan' => string]
 */
function validasi_jumlah($input): array
{
    $gagal = fn(string $pesan) => ['valid' => false, 'nilai' => 0, 'pesan' => $pesan];

    if (!is_string($input)) {
        return $gagal('Jumlah tidak valid.');
    }

    $input = trim($input);

    if ($input === '') {
        return $gagal('Jumlah tidak boleh kosong.');
    }
    if (preg_match('/^-\d+([.,]\d+)?$/', $input)) {
        return $gagal('Jumlah tidak boleh negatif.');
    }
    if (preg_match('/^\d*[.,]\d+$/', $input)) {
        return $gagal('Jumlah harus bilangan bulat, tidak boleh pecahan.');
    }
    if (!preg_match('/^\d+$/', $input)) {
        return $gagal('Jumlah harus berupa angka bilangan bulat.');
    }
    if (strlen($input) > 4) {
        return $gagal('Jumlah harus antara 1 sampai ' . MAKS_JUMLAH . '.');
    }

    $nilai = (int) $input;
    if ($nilai < 1 || $nilai > MAKS_JUMLAH) {
        return $gagal('Jumlah harus antara 1 sampai ' . MAKS_JUMLAH . '.');
    }

    return ['valid' => true, 'nilai' => $nilai, 'pesan' => ''];
}

// ---------- Kategori ----------
function daftar_kategori(array $menu): array
{
    return array_values(array_unique(array_column($menu, 'kategori')));
}

function kategori_valid($kategori, array $pilihan): bool
{
    return is_string($kategori) && in_array($kategori, $pilihan, true);
}

// ---------- Pencarian & filter ----------
function filter_menu(array $menu, string $keyword, string $kategori): array
{
    $hasil = [];
    foreach ($menu as $item) {
        if ($kategori !== 'Semua' && $item['kategori'] !== $kategori) {
            continue;
        }
        if ($keyword !== '' && stripos($item['nama'], $keyword) === false) {
            continue;
        }
        $hasil[] = $item;
    }
    return $hasil;
}

// ---------- Perhitungan ----------
function hitung_subtotal_item(int $harga, int $jumlah): int
{
    return $harga * $jumlah;
}

function hitung_subtotal_pesanan(array $keranjang, array $menu): int
{
    $subtotal = 0;
    foreach ($keranjang as $kode => $jumlah) {
        if (isset($menu[$kode])) {
            $subtotal += hitung_subtotal_item($menu[$kode]['harga'], (int) $jumlah);
        }
    }
    return $subtotal;
}

function hitung_diskon(int $subtotal): int
{
    if ($subtotal >= MIN_DISKON) {
        return (int) round($subtotal * PERSEN_DISKON / 100);
    }
    return 0;
}

function hitung_total(int $subtotal, int $diskon): int
{
    return $subtotal - $diskon;
}

function hitung_ringkasan(array $keranjang, array $menu): array
{
    $subtotal = hitung_subtotal_pesanan($keranjang, $menu);
    $diskon   = hitung_diskon($subtotal);
    return [
        'subtotal' => $subtotal,
        'diskon'   => $diskon,
        'total'    => hitung_total($subtotal, $diskon),
    ];
}

function jumlah_item_keranjang(array $keranjang): int
{
    return (int) array_sum($keranjang);
}
