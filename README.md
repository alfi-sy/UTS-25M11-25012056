# Catatan Hasil Pengujian

Isi kolom **Aktual** dan **Status** (Lulus/Gagal) sesuai hasil uji Anda sendiri, lalu pastikan
nama file screenshot sama dengan yang ada di folder ini.

| ID | Langkah / Input | Harapan | Aktual | Status | Bukti |
|----|-----------------|---------|--------|--------|-------|
| U01 | Buka `index.php` | Minimal 5 menu tampil lengkap (kode, nama, kategori, harga) | (isi) | (isi) | [U01](U01-daftar-menu.png) |
| U02a | Cari "nasi" | Hanya menu yang cocok tampil | (isi) | (isi) | [U02a](U02a-cari-ada.png) |
| U02b | Cari "pizza" | Pesan hasil kosong tampil | (isi) | (isi) | [U02b](U02b-cari-kosong.png) |
| U03a | Jumlah kosong | Ditolak, keranjang tetap | (isi) | (isi) | [U03a](U03a-jumlah-kosong.png) |
| U03b | Jumlah -3 | Ditolak, keranjang tetap | (isi) | (isi) | [U03b](U03b-jumlah-negatif.png) |
| U03c | Jumlah 2.5 | Ditolak, keranjang tetap | (isi) | (isi) | [U03c](U03c-jumlah-pecahan.png) |
| U03d | Jumlah 0 | Ditolak, keranjang tetap | (isi) | (isi) | [U03d](U03d-jumlah-nol.png) |
| U03e | Jumlah 11 | Ditolak, keranjang tetap | (isi) | (isi) | [U03e](U03e-jumlah-11.png) |
| U04 | Ubah kode jadi "X99" lewat DevTools lalu kirim | Ditolak, keranjang tetap | (isi) | (isi) | [U04](U04-kode-tidak-dikenal.png) |
| U05a | Tambah menu sama sampai jumlah 10 (mis. 4 + 6) | Jumlah digabung = 10 | (isi) | (isi) | [U05a](U05a-gabung-10.png) |
| U05b | Tambah 1 lagi | Ditolak, jumlah tetap 10 | (isi) | (isi) | [U05b](U05b-lebih-dari-10.png) |
| U06a | Isi keranjang, lihat sebelum refresh | Isi keranjang tampil | (isi) | (isi) | [U06a](U06a-sebelum-refresh.png) |
| U06b | Refresh dan pindah halaman | Isi keranjang tetap | (isi) | (isi) | [U06b](U06b-sesudah-refresh.png) |
| U07a | Tambah menu via POST | Redirect dan flash tampil | (isi) | (isi) | [U07a](U07a-sebelum-refresh.png) |
| U07b | Refresh (F5) | Jumlah tidak bertambah, flash hilang | (isi) | (isi) | [U07b](U07b-sesudah-refresh.png) |
| U08a | Subtotal Rp49.000 (M01+M02+M03) | Diskon Rp0, total Rp49.000 | (isi) | (isi) | [U08a](U08a-subtotal-49000.png) |
| U08b | Subtotal Rp50.000 (M01x2+M02) | Diskon Rp5.000, total Rp45.000 | (isi) | (isi) | [U08b](U08b-subtotal-50000.png) |
| U09a | Hapus satu item | Item terhapus, total menyesuaikan | (isi) | (isi) | [U09a](U09a-hapus-item.png) |
| U09b | Kosongkan keranjang | Pesan keranjang kosong tampil | (isi) | (isi) | [U09b](U09b-kosongkan.png) |
| U10a | Simpan favorit "Minuman", buka `index.php` tanpa parameter | Kategori = Minuman (sumber cookie) | (isi) | (isi) | [U10a](U10a-cookie-aktif.png) |
| U10b | Buka `index.php?kategori=Snack` | Kategori = Snack (sumber GET) | (isi) | (isi) | [U10b](U10b-get-prioritas.png) |
| U10c | DevTools > Application > Cookies | Cookie `kategori_favorit`, expires +7 hari | (isi) | (isi) | [U10c](U10c-cookie-devtools.png) |
| U11 | Cari `<b>uji</b>` | Tampil sebagai teks biasa, bukan tebal | (isi) | (isi) | [U11](U11-escaping.png) |
