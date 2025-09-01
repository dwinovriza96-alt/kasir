<?php
session_start();
include_once '../config/database.php';

if (isset($_POST['update_pengaturan'])) {
    $nama_aplikasi = anti_injection($_POST['nama_aplikasi']);
    $nama_bisnis = anti_injection($_POST['nama_bisnis']);
    $alamat_bisnis = anti_injection($_POST['alamat_bisnis']);
    $telepon_bisnis = anti_injection($_POST['telepon_bisnis']);
    $footer_text = anti_injection($_POST['footer_text']);
    
    // Handle upload logo
    $logo_aplikasi = $_POST['logo_lama'];
    if (!empty($_FILES['logo_aplikasi']['name'])) {
        $target_dir = "../assets/images/";
        $target_file = $target_dir . basename($_FILES["logo_aplikasi"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["logo_aplikasi"]["tmp_name"]);
        if ($check !== false) {
            // Generate unique filename
            $new_filename = "logo_" . time() . "." . $imageFileType;
            $target_file = $target_dir . $new_filename;
            
            if (move_uploaded_file($_FILES["logo_aplikasi"]["tmp_name"], $target_file)) {
                $logo_aplikasi = $new_filename;
                // Hapus logo lama jika bukan logo default
                if ($_POST['logo_lama'] != 'logo.png') {
                    unlink($target_dir . $_POST['logo_lama']);
                }
            }
        }
    }
    
    $query = "UPDATE pengaturan SET 
              nama_aplikasi = '$nama_aplikasi', 
              logo_aplikasi = '$logo_aplikasi', 
              nama_bisnis = '$nama_bisnis', 
              alamat_bisnis = '$alamat_bisnis', 
              telepon_bisnis = '$telepon_bisnis', 
              footer_text = '$footer_text' 
              WHERE id = 1";
    
    if (mysqli_query($koneksi, $query)) {
        $_SESSION['success'] = "Pengaturan berhasil diupdate";
    } else {
        $_SESSION['error'] = "Error: " . mysqli_error($koneksi);
    }
    header("Location: ../pages/pengaturan.php");
    exit();
}
?>