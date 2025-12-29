<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) { header("Location: login.php"); }

if (isset($_POST['simpan'])) {
    $user_id = $_SESSION['user_id'];
    $tanggal = $_POST['tanggal'];
    $jenis = $_POST['jenis'];
    $kategori = $_POST['kategori'];
    $jumlah = $_POST['jumlah'];
    $keterangan = $_POST['keterangan'];

    $query = "INSERT INTO transaksi (user_id, tanggal, jenis, kategori, jumlah, keterangan) 
              VALUES ('$user_id', '$tanggal', '$jenis', '$kategori', '$jumlah', '$keterangan')";
    
    if (mysqli_query($koneksi, $query)) {
        header("Location: index.php");
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5" style="max-width: 500px;">
        <div class="card shadow">
            <div class="card-header">
                <h5>Tambah Transaksi Baru</h5>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Jenis</label>
                        <select name="jenis" class="form-control" required>
                            <option value="Pengeluaran">Pengeluaran</option>
                            <option value="Pemasukan">Pemasukan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Kategori</label>
                        <input type="text" name="kategori" class="form-control" placeholder="Contoh: Makan, Gaji, Transport" required>
                    </div>
                    <div class="mb-3">
                        <label>Jumlah (Rp)</label>
                        <input type="number" name="jumlah" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Keterangan</label>
                        <textarea name="keterangan" class="form-control"></textarea>
                    </div>
                    <button type="submit" name="simpan" class="btn btn-success w-100">Simpan Data</button>
                    <a href="index.php" class="btn btn-secondary w-100 mt-2">Batal</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>