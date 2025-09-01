<?php
session_start();
include_once '../config/database.php';

if (isset($_POST['proses_transaksi'])) {
    $kode_transaksi = anti_injection($_POST['kode_transaksi']);
    $pelanggan_id = isset($_POST['pelanggan_id']) ? anti_injection($_POST['pelanggan_id']) : NULL;
    $user_id = $_SESSION['user_id'];
    $diskon = anti_injection($_POST['diskon']);
    $total_bayar = anti_injection($_POST['total_bayar']);
    $tunai = anti_injection($_POST['tunai']);
    $kembalian = anti_injection($_POST['kembalian']);
    $catatan = anti_injection($_POST['catatan']);
    
    // Hitung total item
    $total_item = 0;
    if (isset($_POST['cart'])) {
        $total_item = count($_POST['cart']);
    }
    
    // Insert transaksi
    $query_transaksi = "INSERT INTO transaksi (kode_transaksi, pelanggan_id, user_id, total_item, total_harga, diskon, total_bayar, tunai, kembalian, catatan) 
                        VALUES ('$kode_transaksi', '$pelanggan_id', '$user_id', '$total_item', '$total_bayar', '$diskon', '$total_bayar', '$tunai', '$kembalian', '$catatan')";
    
    if (mysqli_query($koneksi, $query_transaksi)) {
        $transaksi_id = mysqli_insert_id($koneksi);
        
        // Insert detail transaksi
        if (isset($_POST['cart'])) {
            foreach ($_POST['cart'] as $item) {
                $produk_id = anti_injection($item['produk_id']);
                $harga = anti_injection($item['harga']);
                $jumlah = anti_injection($item['jumlah']);
                $sub_total = anti_injection($item['sub_total']);
                
                $query_detail = "INSERT INTO transaksi_detail (transaksi_id, produk_id, harga, jumlah, sub_total) 
                                VALUES ('$transaksi_id', '$produk_id', '$harga', '$jumlah', '$sub_total')";
                mysqli_query($koneksi, $query_detail);
                
                // Update stok produk
                $query_update_stok = "UPDATE produk SET stok = stok - $jumlah WHERE id = '$produk_id'";
                mysqli_query($koneksi, $query_update_stok);
            }
        }
        
        $_SESSION['success'] = "Transaksi berhasil diproses!";
        header("Location: ../print/invoice.php?id=" . $transaksi_id);
        exit();
    } else {
        $_SESSION['error'] = "Terjadi kesalahan: " . mysqli_error($koneksi);
        header("Location: ../pages/order.php");
        exit();
    }
}
?>