<?php
$current_page = 'transaksi';
$page_title = 'Data Transaksi';
include_once '../includes/header.php';
include_once '../includes/sidebar.php';
include_once '../includes/navitop.php';

// Ambil data transaksi dengan join pelanggan dan pengguna
$query = mysqli_query($koneksi, "SELECT t.*, p.nama_pelanggan, u.nama_lengkap as kasir 
                                FROM transaksi t 
                                LEFT JOIN pelanggan p ON t.pelanggan_id = p.id 
                                JOIN pengguna u ON t.user_id = u.id 
                                ORDER BY t.tanggal_transaksi DESC");
?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Transaksi</h1>
    </div>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Transaksi</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Kode Transaksi</th>
                            <th>Tanggal</th>
                            <th>Pelanggan</th>
                            <th>Total Item</th>
                            <th>Total Bayar</th>
                            <th>Kasir</th>
                            <th>Status</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        while ($data = mysqli_fetch_array($query)) {
                        ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $data['kode_transaksi']; ?></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($data['tanggal_transaksi'])); ?></td>
                                <td><?php echo $data['nama_pelanggan'] ?? 'Umum'; ?></td>
                                <td><?php echo $data['total_item']; ?></td>
                                <td>Rp <?php echo number_format($data['total_bayar'], 0, ',', '.'); ?></td>
                                <td><?php echo $data['kasir']; ?></td>
                                <td>
                                    <span class="badge <?php echo ($data['status'] == 'selesai') ? 'badge-success' : 'badge-danger'; ?>">
                                        <?php echo ucfirst($data['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="../print/invoice.php?id=<?php echo $data['id']; ?>" target="_blank" class="btn btn-sm btn-info">
                                        <i class="fas fa-print"></i> Print
                                    </a>
                                    <?php if ($data['status'] == 'selesai'): ?>
                                    <a href="../actions/order_actions.php?batalkan_transaksi=true&id=<?php echo $data['id']; ?>" 
                                       class="btn btn-sm btn-danger" 
                                       onclick="return confirm('Yakin ingin membatalkan transaksi ini?')">
                                        <i class="fas fa-times"></i> Batal
                                    </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include_once '../includes/footer.php'; ?>     