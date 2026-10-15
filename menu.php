<?php
/**
 * Data menu kantin (array associative).
 * Kunci array = kode menu (unik).
 *
 * Data uji diskon:
 *  - Rp49.000 = M01 (17.000) + M02 (16.000) + M03 (16.000)
 *  - Rp50.000 = M01 x2 (34.000) + M02 x1 (16.000)   atau   M05 x5
 */
return [
    'M01' => ['kode' => 'M01', 'nama' => 'Nasi Goreng Spesial', 'kategori' => 'Makanan', 'harga' => 17000],
    'M02' => ['kode' => 'M02', 'nama' => 'Ayam Geprek',         'kategori' => 'Makanan', 'harga' => 16000],
    'M03' => ['kode' => 'M03', 'nama' => 'Mie Goreng Telur',    'kategori' => 'Makanan', 'harga' => 16000],
    'M04' => ['kode' => 'M04', 'nama' => 'Es Teh Manis',        'kategori' => 'Minuman', 'harga' => 5000],
    'M05' => ['kode' => 'M05', 'nama' => 'Jus Jeruk',           'kategori' => 'Minuman', 'harga' => 10000],
    'M06' => ['kode' => 'M06', 'nama' => 'Kentang Goreng',      'kategori' => 'Snack',   'harga' => 9000],
    'M07' => ['kode' => 'M07', 'nama' => 'Roti Bakar Coklat',   'kategori' => 'Snack',   'harga' => 12000],
];
