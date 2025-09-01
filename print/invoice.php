<?php
include_once '../config/database.php';

if (isset($_GET['id'])) {
    $transaksi_id = anti_injection($_GET['id']);
    
    // Query transaksi
    $query_transaksi = mysqli_query($koneksi, "SELECT t.*, p.nama_pelanggan, p.alamat, p.telepon, u.nama_lengkap as kasir 
                                              FROM transaksi t 
                                              LEFT JOIN pelanggan p ON t.pelanggan_id = p.id 
                                              JOIN pengguna u ON t.user_id = u.id 
                                              WHERE t.id = '$transaksi_id'");
    $transaksi = mysqli_fetch_assoc($query_transaksi);
    
    // Query detail transaksi
    $query_detail = mysqli_query($koneksi, "SELECT td.*, pr.nama_produk, pr.kode_produk 
                                           FROM transaksi_detail td 
                                           JOIN produk pr ON td.produk_id = pr.id 
                                           WHERE td.transaksi_id = '$transaksi_id'");
    
    // Query pengaturan
    $query_pengaturan = mysqli_query($koneksi, "SELECT * FROM pengaturan WHERE id = 1");
    $pengaturan = mysqli_fetch_assoc($query_pengaturan);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice #<?php echo $transaksi['kode_transaksi']; ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; }
        .invoice { max-width: 800px; margin: 0 auto; border: 1px solid #ddd; padding: 20px; }
        .header { text-align: center; margin-bottom: 20px; }
        .info { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-right { text-align: right; }
        .footer { margin-top: 30px; text-align: center; }
    </style>
</head>
<body>
    <div class="invoice">
        <div class="header">
            <h2><?php echo $pengaturan['nama_bisnis']; ?></h2>
            <p><?php echo $pengaturan['alamat_bisnis']; ?></p>
            <p>Telp: <?php echo $pengaturan['telepon_bisnis']; ?></p>
            <h3>INVOICE</h3>
        </div>
        
        <div class="info">
            <table>
                <tr>
                    <td width="20%">No. Transaksi</td>
                    <td width="30%">: <?php echo $transaksi['kode_transaksi']; ?></td>
                    <td width="20%">Pelanggan</td>
                    <td width="30%">: <?php echo $transaksi['nama_pelanggan'] ?? 'Umum'; ?></td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td>: <?php echo date('d/m/Y H:i', strtotime($transaksi['tanggal_transaksi'])); ?></td>
                    <td>Alamat</td>
                    <td>: <?php echo $transaksi['alamat'] ?? '-'; ?></td>
                </tr>
                <tr>
                    <td>Kasir</td>
                    <td>: <?php echo $transaksi['kasir']; ?></td>
                    <td>Telepon</td>
                    <td>: <?php echo $transaksi['telepon'] ?? '-'; ?></td>
                </tr>
            </table>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while ($detail = mysqli_fetch_array($query_detail)) {
                    echo "<tr>
                            <td>{$no}</td>
                            <td>{$detail['kode_produk']}</td>
                            <td>{$detail['nama_produk']}</td>
                            <td>Rp " . number_format($detail['harga'], 0, ',', '.') . "</td>
                            <td>{$detail['jumlah']}</td>
                            <td>Rp " . number_format($detail['sub_total'], 0, ',', '.') . "</td>
                          </tr>";
                    $no++;
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="5" class="text-right">Total</th>
                    <th>Rp <?php echo number_format($transaksi['total_bayar'] + $transaksi['diskon'], 0, ',', '.'); ?></th>
                </tr>
                <tr>
                    <th colspan="5" class="text-right">Diskon</th>
                    <th>Rp <?php echo number_format($transaksi['diskon'], 0, ',', '.'); ?></th>
                </tr>
                <tr>
                    <th colspan="5" class="text-right">Total Bayar</th>
                    <th>Rp <?php echo number_format($transaksi['total_bayar'], 0, ',', '.'); ?></th>
                </tr>
                <tr>
                    <th colspan="5" class="text-right">Tunai</th>
                    <th>Rp <?php echo number_format($transaksi['tunai'], 0, ',', '.'); ?></th>
                </tr>
                <tr>
                    <th colspan="5" class="text-right">Kembalian</th>
                    <th>Rp <?php echo number_format($transaksi['kembalian'], 0, ',', '.'); ?></th>
                </tr>
            </tfoot>
        </table>
        
        <div class="footer">
            <p>Terima kasih atas kunjungan Anda</p>
            <p><?php echo $pengaturan['footer_text']; ?></p>
        </div>
    </div>
    
    <script>
        window.onload = function() {
            window.print();
            setTimeout(function() {
                window.location.href = '../pages/order.php';
            }, 1000);
        }
    </script>
</body>
</html>