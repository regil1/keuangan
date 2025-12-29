<?php
session_start();
include 'koneksi.php';

$id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Hapus data, TAPI pastikan data itu milik user yang sedang login (keamanan)
$query = "DELETE FROM transaksi WHERE id='$id' AND user_id='$user_id'";
mysqli_query($koneksi, $query);

header("Location: index.php");
?>