<?php
session_start();
include_once '../config/database.php';

if (isset($_POST['tambah_pelanggan'])) {
    $kode_pelanggan = anti_injection($_POST['kode_pelanggan']);
    $nama_pelanggan = anti_injection($_POST['nama_pelanggan']);
    $alamat = anti_injection($_POST['alamat']);
    $telepon = anti_injection($_POST['telepon']);
    $email = anti_injection($_POST['email']);
    
    $query = "INSERT INTO pelanggan (kode_pelanggan, nama_pelanggan, alamat, telepon, email) 
              VALUES ('$kode_pelanggan', '$nama_pelanggan', '$alamat', '$telepon', '$email')";
    
    if (mysqli_query($koneksi, $query)) {
        $_SESSION['success'] = "Pelanggan berhasil ditambahkan";
    } else {
        $_SESSION['error'] = "Error: " . mysqli_error($koneksi);
    }
    header("Location: ../pages/pelanggan.php");
    exit();
}

if (isset($_POST['edit_pelanggan'])) {
    $id = anti_injection($_POST['id']);
    $kode_pelanggan = anti_injection($_POST['kode_pelanggan']);
    $nama_pelanggan = anti_injection($_POST['nama_pelanggan']);
    $alamat = anti_injection($_POST['alamat']);
    $telepon = anti_injection($_POST['telepon']);
    $email = anti_injection($_POST['email']);
    
    $query = "UPDATE pelanggan SET 
              kode_pelanggan = '$kode_pelanggan', 
              nama_pelanggan = '$nama_pelanggan', 
              alamat = '$alamat', 
              telepon = '$telepon', 
              email = '$email' 
              WHERE id = '$id'";
    
    if (mysqli_query($koneksi, $query)) {
        $_SESSION['success'] = "Pelanggan berhasil diupdate";
    } else {
        $_SESSION['error'] = "Error: " . mysqli_error($koneksi);
    }
    header("Location: ../pages/pelanggan.php");
    exit();
}

if (isset($_GET['hapus_pelanggan'])) {
    $id = anti_injection($_GET['id']);
    
    $query = "UPDATE pelanggan SET status = 'nonaktif' WHERE id = '$id'";
    
    if (mysqli_query($koneksi, $query)) {
        $_SESSION['success'] = "Pelanggan berhasil dihapus";
    } else {
        $_SESSION['error'] = "Error: " . mysqli_error($koneksi);
    }
    header("Location: ../pages/pelanggan.php");
    exit();
}
?>