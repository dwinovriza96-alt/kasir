<?php
session_start();
include_once '../config/database.php';

if (isset($_POST['tambah_kategori'])) {
    $nama_kategori = anti_injection($_POST['nama_kategori']);
    $deskripsi = anti_injection($_POST['deskripsi']);
    
    $query = "INSERT INTO kategori (nama_kategori, deskripsi) 
              VALUES ('$nama_kategori', '$deskripsi')";
    
    if (mysqli_query($koneksi, $query)) {
        $_SESSION['success'] = "Kategori berhasil ditambahkan";
    } else {
        $_SESSION['error'] = "Error: " . mysqli_error($koneksi);
    }
    header("Location: ../pages/kategori.php");
    exit();
}

if (isset($_POST['edit_kategori'])) {
    $id = anti_injection($_POST['id']);
    $nama_kategori = anti_injection($_POST['nama_kategori']);
    $deskripsi = anti_injection($_POST['deskripsi']);
    
    $query = "UPDATE kategori SET 
              nama_kategori = '$nama_kategori', 
              deskripsi = '$deskripsi' 
              WHERE id = '$id'";
    
    if (mysqli_query($koneksi, $query)) {
        $_SESSION['success'] = "Kategori berhasil diupdate";
    } else {
        $_SESSION['error'] = "Error: " . mysqli_error($koneksi);
    }
    header("Location: ../pages/kategori.php");
    exit();
}

if (isset($_GET['hapus_kategori'])) {
    $id = anti_injection($_GET['id']);
    
    // Cek apakah kategori digunakan oleh produk
    $cek_produk = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM produk WHERE kategori_id = '$id'");
    $data = mysqli_fetch_assoc($cek_produk);
    
    if ($data['total'] > 0) {
        $_SESSION['error'] = "Kategori tidak dapat dihapus karena masih digunakan oleh produk";
    } else {
        $query = "UPDATE kategori SET status = 'nonaktif' WHERE id = '$id'";
        
        if (mysqli_query($koneksi, $query)) {
            $_SESSION['success'] = "Kategori berhasil dihapus";
        } else {
            $_SESSION['error'] = "Error: " . mysqli_error($koneksi);
        }
    }
    header("Location: ../pages/kategori.php");
    exit();
}
?>