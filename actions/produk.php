<?php
session_start();
include_once '../config/database.php';

if (isset($_POST['tambah_produk'])) {
    $kode_produk = anti_injection($_POST['kode_produk']);
    $nama_produk = anti_injection($_POST['nama_produk']);
    $kategori_id = anti_injection($_POST['kategori_id']);
    $satuan_id = anti_injection($_POST['satuan_id']);
    $harga_beli = anti_injection($_POST['harga_beli']);
    $harga_jual = anti_injection($_POST['harga_jual']);
    $stok = anti_injection($_POST['stok']);
    $minimal_stok = anti_injection($_POST['minimal_stok']);
    
    $query = "INSERT INTO produk (kode_produk, nama_produk, kategori_id, satuan_id, harga_beli, harga_jual, stok, minimal_stok) 
              VALUES ('$kode_produk', '$nama_produk', '$kategori_id', '$satuan_id', '$harga_beli', '$harga_jual', '$stok', '$minimal_stok')";
    
    if (mysqli_query($koneksi, $query)) {
        $_SESSION['success'] = "Produk berhasil ditambahkan";
    } else {
        $_SESSION['error'] = "Error: " . mysqli_error($koneksi);
    }
    header("Location: ../pages/produk.php");
    exit();
}

if (isset($_POST['edit_produk'])) {
    $id = anti_injection($_POST['id']);
    $kode_produk = anti_injection($_POST['kode_produk']);
    $nama_produk = anti_injection($_POST['nama_produk']);
    $kategori_id = anti_injection($_POST['kategori_id']);
    $satuan_id = anti_injection($_POST['satuan_id']);
    $harga_beli = anti_injection($_POST['harga_beli']);
    $harga_jual = anti_injection($_POST['harga_jual']);
    $stok = anti_injection($_POST['stok']);
    $minimal_stok = anti_injection($_POST['minimal_stok']);
    
    $query = "UPDATE produk SET 
              kode_produk = '$kode_produk', 
              nama_produk = '$nama_produk', 
              kategori_id = '$kategori_id', 
              satuan_id = '$satuan_id', 
              harga_beli = '$harga_beli', 
              harga_jual = '$harga_jual', 
              stok = '$stok', 
              minimal_stok = '$minimal_stok' 
              WHERE id = '$id'";
    
    if (mysqli_query($koneksi, $query)) {
        $_SESSION['success'] = "Produk berhasil diupdate";
    } else {
        $_SESSION['error'] = "Error: " . mysqli_error($koneksi);
    }
    header("Location: ../pages/produk.php");
    exit();
}

if (isset($_GET['hapus_produk'])) {
    $id = anti_injection($_GET['id']);
    
    $query = "UPDATE produk SET status = 'nonaktif' WHERE id = '$id'";
    
    if (mysqli_query($koneksi, $query)) {
        $_SESSION['success'] = "Produk berhasil dihapus";
    } else {
        $_SESSION['error'] = "Error: " . mysqli_error($koneksi);
    }
    header("Location: ../pages/produk.php");
    exit();
}
?>