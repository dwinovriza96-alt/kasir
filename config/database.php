<?php
$host = "localhost";      // Host database
$user = "root";           // Username database
$pass = "";               // Password database
$dbname = "kasir_app";    // Nama database

$koneksi = mysqli_connect($host, $user, $pass, $dbname);

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Fungsi untuk mencegah SQL injection
function anti_injection($data) {
    global $koneksi;
    $filter = mysqli_real_escape_string($koneksi, stripslashes(strip_tags(htmlspecialchars($data, ENT_QUOTES))));
    return $filter;
}
?>