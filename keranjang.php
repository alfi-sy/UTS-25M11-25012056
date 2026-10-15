<?php
$menu = require __DIR__ . '/data/menu.php';
require __DIR__ . '/includes/fungsi.php';

$keranjang = $_SESSION['keranjang'];
$ringkasan = hitung_ringkasan($keranjang, $menu);

$judulHalaman = 'Keranjang';
$halamanAktif = 'keranjang';
require __DIR__ . '/includes/header.php';
?>

<h1>Keranjang Pesanan</h1>

<?php if (count($keranjang) === 0): ?>
    <div class="card kosong">
        Keranjang masih kosong. Pilih menu di halaman
        <a href="index.php">Daftar Menu</a>.
    </div>
<?php else: ?>
    <div class="card">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Menu</th>
                        <th class="num">Harga</th>
                        <th class="num">Jumlah</th>
                        <th class="num">Subtotal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($keranjang as $kode => $jumlah): ?>
                    <?php if (!isset($menu[$kode])) { continue; } ?>
                    <?php $item = $menu[$kode]; ?>
                    <tr>
                        <td><?= e($item['nama']) ?> <small class="muted">(<?= e($kode) ?>)</small></td>
                        <td class="num"><?= rupiah($item['harga']) ?></td>
                        <td class="num"><?= (int) $jumlah ?></td>
                        <td class="num"><?= rupiah(hitung_subtotal_item($item['harga'], (int) $jumlah)) ?></td>
                        <td>
                            <form method="post" action="proses.php">
                                <input type="hidden" name="aksi" value="hapus">
                                <input type="hidden" name="halaman" value="keranjang.php">
                                <input type="hidden" name="kode" value="<?= e($kode) ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <dl class="ringkasan">
            <div><dt>Subtotal seluruh pesanan</dt><dd><?= rupiah($ringkasan['subtotal']) ?></dd></div>
            <div><dt>Diskon <?= PERSEN_DISKON ?>% <small class="muted">(min. <?= rupiah(MIN_DISKON) ?>)</small></dt>
                 <dd>- <?= rupiah($ringkasan['diskon']) ?></dd></div>
            <div class="total"><dt>Total akhir</dt><dd><?= rupiah($ringkasan['total']) ?></dd></div>
        </dl>

        <form method="post" action="proses.php" class="row">
            <input type="hidden" name="aksi" value="kosongkan">
            <input type="hidden" name="halaman" value="keranjang.php">
            <button type="submit" class="btn btn-danger">Kosongkan keranjang</button>
            <a href="index.php" class="btn btn-ghost">Tambah menu lain</a>
        </form>
    </div>
<?php endif; ?>

<?php require __DIR__ . '/includes/footer.php'; ?>
