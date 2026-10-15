# Aplikasi Pemesanan Kantin Kampus

| | |
|---|---|
| **Nama** | (isi nama lengkap) |
| **NIM** | (isi NIM) |
| **Kelas** | 25M11 |
| **Mata Kuliah** | Web I - UTS Praktik |
| **Program Studi** | D3 Manajemen Informatika, Politeknik Ganesha Medan |

## Deskripsi
Aplikasi web sederhana (PHP native, tanpa framework dan database) untuk memesan menu
kantin kampus. Fitur: daftar menu dan pencarian (GET), form pemesanan dengan validasi
server (POST), keranjang berbasis session, diskon 10% untuk subtotal minimal Rp50.000,
pola Post/Redirect/Get dengan flash message, dan preferensi kategori favorit memakai cookie 7 hari.

## Kebutuhan Server Lokal
- PHP 8.0 atau lebih baru
- Server lokal: XAMPP / Laragon, atau PHP built-in server

## Cara Menjalankan
**Opsi 1 - PHP built-in server**
```bash
cd uts-web1-NIM
php -S localhost:8000
```
Buka `http://localhost:8000/index.php`

**Opsi 2 - XAMPP/Laragon**
Letakkan folder `uts-web1-NIM` di `htdocs` (XAMPP) atau `www` (Laragon), nyalakan Apache,
lalu buka `http://localhost/uts-web1-NIM/`.

## Struktur Project
- `index.php` : daftar menu, pencarian, form pesan, kategori favorit
- `keranjang.php` : tampilan keranjang, ringkasan harga
- `proses.php` : pemroses POST (tambah, hapus, kosongkan, simpan kategori)
- `data/menu.php` : data menu (array associative)
- `includes/` : `fungsi.php`, `header.php`, `footer.php`
- `assets/style.css` : tampilan
- `dokumentasi/pengujian/` : catatan dan screenshot pengujian

## Data Uji Diskon
- Rp49.000 : M01 + M02 + M03 (17.000 + 16.000 + 16.000)
- Rp50.000 : M01 x2 + M02 x1 (34.000 + 16.000), atau M05 x5
