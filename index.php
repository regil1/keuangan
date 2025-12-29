<?php
session_start();
include 'koneksi.php';

// Cek apakah user sudah login? Kalau belum, tendang ke login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Hitung Total Pemasukan
$query_masuk = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total FROM transaksi WHERE user_id='$user_id' AND jenis='Pemasukan'");
$pemasukan = mysqli_fetch_assoc($query_masuk)['total'] ?: 0;

// Hitung Total Pengeluaran
$query_keluar = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total FROM transaksi WHERE user_id='$user_id' AND jenis='Pengeluaran'");
$pengeluaran = mysqli_fetch_assoc($query_keluar)['total'] ?: 0;

// Hitung Saldo
$saldo = $pemasukan - $pengeluaran;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Keuanganku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Keuanganku</a>
            <span class="navbar-text text-white">Halo, <?php echo $_SESSION['nama']; ?> | <a href="logout.php" class="btn btn-sm btn-danger ml-2">Logout</a></span>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row text-center">
            <div class="col-md-4">
                <div class="card bg-success text-white mb-3">
                    <div class="card-body">
                        <h5>Pemasukan</h5>
                        <h3>Rp <?php echo number_format($pemasukan); ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-danger text-white mb-3">
                    <div class="card-body">
                        <h5>Pengeluaran</h5>
                        <h3>Rp <?php echo number_format($pengeluaran); ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-primary text-white mb-3">
                    <div class="card-body">
                        <h5>Sisa Saldo</h5>
                        <h3>Rp <?php echo number_format($saldo); ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow mt-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Riwayat Transaksi</h5>
                <a href="tambah.php" class="btn btn-primary btn-sm">+ Tambah Data</a>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Kategori</th>
                            <th>Keterangan</th>
                            <th>Jenis</th>
                            <th>Jumlah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Ambil data transaksi user ini
                        $data = mysqli_query($koneksi, "SELECT * FROM transaksi WHERE user_id='$user_id' ORDER BY tanggal DESC");
                        while ($d = mysqli_fetch_assoc($data)) {
                            // Tentukan warna teks
                            $warna = ($d['jenis'] == 'Pemasukan') ? 'text-success' : 'text-danger';
                        ?>
                        <tr>
                            <td><?php echo $d['tanggal']; ?></td>
                            <td><?php echo $d['kategori']; ?></td>
                            <td><?php echo $d['keterangan']; ?></td>
                            <td class="<?php echo $warna; ?> fw-bold"><?php echo $d['jenis']; ?></td>
                            <td>Rp <?php echo number_format($d['jumlah']); ?></td>
                            <td>
                                <a href="hapus.php?id=<?php echo $d['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>