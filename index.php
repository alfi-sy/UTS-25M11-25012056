<?php
$menu = require __DIR__ . '/data/menu.php';
require __DIR__ . '/includes/fungsi.php';

// ---------- Kategori ----------
$pilihanKategori = array_merge(['Semua'], daftar_kategori($menu));

$kategoriAktif  = 'Semua';
$sumberKategori = 'bawaan';
$peringatan     = null;

$kategoriGet    = $_GET['kategori'] ?? null;
$kategoriCookie = $_COOKIE[COOKIE_KATEGORI] ?? null;

// Prioritas 1: parameter GET
if ($kategoriGet !== null) {
    if (kategori_valid($kategoriGet, $pilihanKategori)) {
        $kategoriAktif  = $kategoriGet;
        $sumberKategori = 'GET';
    } else {
        $peringatan = 'Kategori pada URL tidak valid dan diabaikan.';
    }
}
// Prioritas 2: cookie (jika GET tidak ada/tidak valid)
if ($sumberKategori === 'bawaan' && kategori_valid($kategoriCookie, $pilihanKategori)) {
    $kategoriAktif  = $kategoriCookie;
    $sumberKategori = 'cookie';
}

// ---------- Pencarian ----------
$keyword = (isset($_GET['q']) && is_string($_GET['q'])) ? trim($_GET['q']) : '';
$hasil   = filter_menu($menu, $keyword, $kategoriAktif);

$judulHalaman = 'Daftar Menu';
$halamanAktif = 'menu';
require __DIR__ . '/includes/header.php';
?>

<h1>Daftar Menu</h1>

<?php if ($peringatan): ?>
    <div class="flash flash-info"><?= e($peringatan) ?></div>
<?php endif; ?>

<section class="grid-2">
    <!-- Form pencarian & filter (GET) -->
    <div class="card">
        <h2>Cari menu</h2>
        <form method="get" action="index.php" class="form">
            <label for="q">Nama menu</label>
            <input type="text" id="q" name="q" value="<?= e($keyword) ?>" placeholder="Contoh: nasi">

            <label for="kategori">Kategori</label>
            <select id="kategori" name="kategori">
                <?php foreach ($pilihanKategori as $kat): ?>
                    <option value="<?= e($kat) ?>" <?= $kat === $kategoriAktif ? 'selected' : '' ?>>
                        <?= e($kat) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <div class="row">
                <button type="submit" class="btn">Cari</button>
                <a href="index.php" class="btn btn-ghost">Reset</a>
            </div>
        </form>
    </div>

    <!-- Form tambah pesanan (POST) -->
    <div class="card">
        <h2>Tambah pesanan</h2>
        <form method="post" action="proses.php" class="form" novalidate>
            <input type="hidden" name="aksi" value="tambah">
            <input type="hidden" name="halaman" value="index.php">

            <label for="kode">Menu</label>
            <select id="kode" name="kode">
                <?php foreach ($menu as $item): ?>
                    <option value="<?= e($item['kode']) ?>">
                        <?= e($item['kode']) ?> - <?= e($item['nama']) ?> (<?= rupiah($item['harga']) ?>)
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="jumlah">Jumlah (1-10)</label>
            <input type="text" id="jumlah" name="jumlah" value="1" inputmode="numeric" autocomplete="off">

            <button type="submit" class="btn">Tambah ke keranjang</button>
        </form>
    </div>
</section>

<section class="card">
    <div class="status-bar">
        <span>Kategori aktif: <strong><?= e($kategoriAktif) ?></strong>
            <small class="muted">(sumber: <?= e($sumberKategori) ?>)</small></span>
        <?php if ($keyword !== ''): ?>
            <span>Kata kunci: <strong><?= e($keyword) ?></strong></span>
        <?php endif; ?>
    </div>

    <?php if (count($hasil) === 0): ?>
        <div class="kosong">
            <?php if ($keyword !== ''): ?>
                Menu dengan kata kunci "<strong><?= e($keyword) ?></strong>" tidak ditemukan
                pada kategori <?= e($kategoriAktif) ?>.
            <?php else: ?>
                Tidak ada menu pada kategori <?= e($kategoriAktif) ?>.
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama menu</th>
                        <th>Kategori</th>
                        <th class="num">Harga</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($hasil as $item): ?>
                    <tr>
                        <td><?= e($item['kode']) ?></td>
                        <td><?= e($item['nama']) ?></td>
                        <td><span class="tag"><?= e($item['kategori']) ?></span></td>
                        <td class="num"><?= rupiah($item['harga']) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</section>

<!-- Preferensi kategori favorit (cookie 7 hari) -->
<section class="card">
    <h2>Kategori favorit</h2>
    <p class="muted">
        Disimpan di cookie selama 7 hari dan dipakai sebagai kategori awal saat halaman dibuka.
        Parameter <code>?kategori=...</code> pada URL selalu didahulukan.
    </p>
    <form method="post" action="proses.php" class="form form-inline">
        <input type="hidden" name="aksi" value="simpan_kategori">
        <label for="fav">Pilih kategori</label>
        <select id="fav" name="kategori_favorit">
            <?php foreach ($pilihanKategori as $kat): ?>
                <option value="<?= e($kat) ?>" <?= (is_string($kategoriCookie) && $kategoriCookie === $kat) ? 'selected' : '' ?>>
                    <?= e($kat) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="btn">Simpan favorit</button>
    </form>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
