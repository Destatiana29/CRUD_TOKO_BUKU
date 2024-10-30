<?php
session_start();

// Jika belum ada session barang, inisialisasi data barang
if (!isset($_SESSION['barang'])) {
    $_SESSION['barang'] = [
        ['id' => 1, 'nama' => 'Pensil', 'kategori' => 'Alat Tulis', 'harga' => 2000],
        ['id' => 2, 'nama' => 'Penghapus', 'kategori' => 'Alat Tulis', 'harga' => 1000],
    ];
}

// Ambil data barang dari session
$barang = $_SESSION['barang'];

// Fungsi untuk menambah barang
if (isset($_POST['tambah'])) {
    $id = count($barang) + 1; // ID auto-increment
    $nama = $_POST['nama'];
    $kategori = $_POST['kategori'];
    $harga = $_POST['harga'];
    $barang[] = ['id' => $id, 'nama' => $nama, 'kategori' => $kategori, 'harga' => $harga];
    $_SESSION['barang'] = $barang; // Simpan perubahan ke session
}

// Fungsi untuk mengedit barang
if (isset($_POST['edit'])) {
    $editIndex = $_POST['edit'];
    if (isset($barang[$editIndex])) {
        $nama = $barang[$editIndex]['nama'];
        $kategori = $barang[$editIndex]['kategori'];
        $harga = $barang[$editIndex]['harga']; // Pastikan variabel sesuai dengan konvensi
    } else {
        echo "Barang tidak ditemukan!";
    }
}

// Fungsi untuk menghapus barang
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    foreach ($barang as $key => $b) {
        if ($b['id'] == $id) {
            unset($barang[$key]);
        }
    }
    $_SESSION['barang'] = $barang; // Simpan perubahan ke session
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Barang</title>
</head>
<body>
    <h1>Daftar Barang</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($barang as $b): ?>
            <tr>
                <td><?= $b['id'] ?></td>
                <td><?= $b['nama'] ?></td>
                <td><?= $b['kategori'] ?></td>
                <td><?= $b['harga'] ?></td>
                <td>
                    <a href="edit.php?id=<?= $b['id'] ?>">Edit</a>
                    <a href="?hapus=<?= $b['id'] ?>" onclick="return confirm('Yakin ingin menghapus barang ini?')">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Tambah Barang Baru</h2>
    <form method="post" action="">
        <label>Nama Barang:</label>
        <input type="text" name="nama" required><br>
        <label>Kategori:</label>
        <input type="text" name="kategori" required><br>
        <label>Harga:</label>
        <input type="number" name="harga" required><br>
        <input type="submit" name="tambah" value="Tambah Barang">
    </form>
</body>
</html>