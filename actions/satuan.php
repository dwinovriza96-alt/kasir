<?php
session_start();
include_once '../config/database.php';

if (isset($_POST['tambah_satuan'])) {
    $nama_satuan = anti_injection($_POST['nama_satuan']);
    
    $query = "INSERT INTO satuan (nama_satuan) VALUES ('$nama_satuan')";
    
    if (mysqli_query($koneksi, $query)) {
        $_SESSION['success'] = "Satuan berhasil ditambahkan";
    } else {
        $_SESSION['error'] = "Error: " . mysqli_error($koneksi);
    }
    header("Location: ../pages/satuan.php");
    exit();
}

if (isset($_POST['edit_satuan'])) {
    $id = anti_injection($_POST['id']);
    $nama_satuan = anti_injection($_POST['nama_satuan']);
    
    $query = "UPDATE satuan SET nama_satuan = '$nama_satuan' WHERE id = '$id'";
    
    if (mysqli_query($koneksi, $query)) {
        $_SESSION['success'] = "Satuan berhasil diupdate";
    } else {
        $_SESSION['error'] = "Error: " . mysqli_error($koneksi);
    }
    header("Location: ../pages/satuan.php");
    exit();
}

if (isset($_GET['hapus_satuan'])) {
    $id = anti_injection($_GET['id']);
    
    // Cek apakah satuan digunakan oleh produk
    $cek_produk = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM produk WHERE satuan_id = '$id'");
    $data = mysqli_fetch_assoc($cek_produk);
    
    if ($data['total'] > 0) {
        $_SESSION['error'] = "Satuan tidak dapat dihapus karena masih digunakan oleh produk";
    } else {
        $query = "UPDATE satuan SET status = 'nonaktif' WHERE id = '$id'";
        
        if (mysqli_query($koneksi, $query)) {
            $_SESSION['success'] = "Satuan berhasil dihapus";
        } else {
            $_SESSION['error'] = "Error: " . mysqli_error($koneksi);
        }
    }
    header("Location: ../pages/satuan.php");
    exit();
}
?>