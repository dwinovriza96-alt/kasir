<?php
session_start();
include_once '../config/database.php';

if (isset($_POST['tambah_pengguna'])) {
    $username = anti_injection($_POST['username']);
    $password = password_hash(anti_injection($_POST['password']), PASSWORD_DEFAULT);
    $nama_lengkap = anti_injection($_POST['nama_lengkap']);
    $level = anti_injection($_POST['level']);
    
    // Cek apakah username sudah ada
    $cek_username = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM pengguna WHERE username = '$username'");
    $data = mysqli_fetch_assoc($cek_username);
    
    if ($data['total'] > 0) {
        $_SESSION['error'] = "Username sudah digunakan";
    } else {
        $query = "INSERT INTO pengguna (username, password, nama_lengkap, level) 
                  VALUES ('$username', '$password', '$nama_lengkap', '$level')";
        
        if (mysqli_query($koneksi, $query)) {
            $_SESSION['success'] = "Pengguna berhasil ditambahkan";
        } else {
            $_SESSION['error'] = "Error: " . mysqli_error($koneksi);
        }
    }
    header("Location: ../pages/pengguna.php");
    exit();
}

if (isset($_POST['edit_pengguna'])) {
    $id = anti_injection($_POST['id']);
    $nama_lengkap = anti_injection($_POST['nama_lengkap']);
    $level = anti_injection($_POST['level']);
    $status = anti_injection($_POST['status']);
    
    $query = "UPDATE pengguna SET 
              nama_lengkap = '$nama_lengkap', 
              level = '$level', 
              status = '$status' 
              WHERE id = '$id'";
    
    // Jika password diisi, update password juga
    if (!empty($_POST['password'])) {
        $password = password_hash(anti_injection($_POST['password']), PASSWORD_DEFAULT);
        $query = "UPDATE pengguna SET 
                  nama_lengkap = '$nama_lengkap', 
                  level = '$level', 
                  status = '$status',
                  password = '$password'
                  WHERE id = '$id'";
    }
    
    if (mysqli_query($koneksi, $query)) {
        $_SESSION['success'] = "Pengguna berhasil diupdate";
    } else {
        $_SESSION['error'] = "Error: " . mysqli_error($koneksi);
    }
    header("Location: ../pages/pengguna.php");
    exit();
}

if (isset($_GET['hapus_pengguna'])) {
    $id = anti_injection($_GET['id']);
    
    // Tidak boleh menghapus user sendiri
    if ($id == $_SESSION['user_id']) {
        $_SESSION['error'] = "Tidak dapat menghapus akun sendiri";
    } else {
        $query = "UPDATE pengguna SET status = 'nonaktif' WHERE id = '$id'";
        
        if (mysqli_query($koneksi, $query)) {
            $_SESSION['success'] = "Pengguna berhasil dihapus";
        } else {
            $_SESSION['error'] = "Error: " . mysqli_error($koneksi);
        }
    }
    header("Location: ../pages/pengguna.php");
    exit();
}
?>