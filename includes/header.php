<?php
session_start();
include_once '../config/database.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

// Ambil data pengaturan
$query_pengaturan = mysqli_query($koneksi, "SELECT * FROM pengaturan WHERE id = 1");
$pengaturan = mysqli_fetch_assoc($query_pengaturan);

// Ambil data user yang login
$user_id = $_SESSION['user_id'];
$query_user = mysqli_query($koneksi, "SELECT * FROM pengguna WHERE id = '$user_id'");
$user = mysqli_fetch_assoc($query_user);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pengaturan['nama_aplikasi']; ?> - <?php echo $page_title ?? 'Dashboard'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="icon" href="../assets/images/<?php echo $pengaturan['logo_aplikasi']; ?>" type="image/png">
</head>
<body>