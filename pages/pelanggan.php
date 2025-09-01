<?php
$current_page = 'pelanggan';
$page_title = 'Data Pelanggan';
include_once '../includes/header.php';
include_once '../includes/sidebar.php';
include_once '../includes/navitop.php';

// Ambil data pelanggan
$query = mysqli_query($koneksi, "SELECT * FROM pelanggan WHERE status = 'aktif' ORDER BY nama_pelanggan");
?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Pelanggan</h1>
        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambahPelangganModal">
            <i class="fas fa-plus fa-sm"></i> Tambah Pelanggan
        </button>
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
            <h6 class="m-0 font-weight-bold text-primary">Daftar Pelanggan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Kode</th>
                            <th>Nama Pelanggan</th>
                            <th>Telepon</th>
                            <th>Email</th>
                            <th>Tanggal Daftar</th>
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
                                <td><?php echo $data['kode_pelanggan']; ?></td>
                                <td><?php echo $data['nama_pelanggan']; ?></td>
                                <td><?php echo $data['telepon']; ?></td>
                                <td><?php echo $data['email']; ?></td>
                                <td><?php echo date('d/m/Y', strtotime($data['tanggal_daftar'])); ?></td>
                                <td>
                                    <button class="btn btn-sm btn-warning edit-pelanggan" data-id="<?php echo $data['id']; ?>" 
                                            data-kode="<?php echo $data['kode_pelanggan']; ?>" 
                                            data-nama="<?php echo $data['nama_pelanggan']; ?>" 
                                            data-alamat="<?php echo $data['alamat']; ?>" 
                                            data-telepon="<?php echo $data['telepon']; ?>" 
                                            data-email="<?php echo $data['email']; ?>">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <a href="../actions/pelanggan_actions.php?hapus_pelanggan=true&id=<?php echo $data['id']; ?>" 
                                       class="btn btn-sm btn-danger" 
                                       onclick="return confirm('Yakin ingin menghapus pelanggan ini?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Pelanggan -->
<div class="modal fade" id="tambahPelangganModal" tabindex="-1" role="dialog" aria-labelledby="tambahPelangganModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahPelangganModalLabel">Tambah Pelanggan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="../actions/pelanggan_actions.php" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="kode_pelanggan">Kode Pelanggan</label>
                        <input type="text" class="form-control" id="kode_pelanggan" name="kode_pelanggan" value="PLG<?php echo date('YmdHis'); ?>" required readonly>
                    </div>
                    <div class="form-group">
                        <label for="nama_pelanggan">Nama Pelanggan</label>
                        <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan" required>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="telepon">Telepon</label>
                        <input type="text" class="form-control" id="telepon" name="telepon">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" name="tambah_pelanggan" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Pelanggan -->
<div class="modal fade" id="editPelangganModal" tabindex="-1" role="dialog" aria-labelledby="editPelangganModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPelangganModalLabel">Edit Pelanggan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="../actions/pelanggan_actions.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" id="edit_id" name="id">
                    <div class="form-group">
                        <label for="edit_kode_pelanggan">Kode Pelanggan</label>
                        <input type="text" class="form-control" id="edit_kode_pelanggan" name="kode_pelanggan" required readonly>
                    </div>
                    <div class="form-group">
                        <label for="edit_nama_pelanggan">Nama Pelanggan</label>
                        <input type="text" class="form-control" id="edit_nama_pelanggan" name="nama_pelanggan" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_alamat">Alamat</label>
                        <textarea class="form-control" id="edit_alamat" name="alamat" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="edit_telepon">Telepon</label>
                        <input type="text" class="form-control" id="edit_telepon" name="telepon">
                    </div>
                    <div class="form-group">
                        <label for="edit_email">Email</label>
                        <input type="email" class="form-control" id="edit_email" name="email">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" name="edit_pelanggan" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once '../includes/footer.php'; ?>

<script>
$(document).ready(function() {
    // Edit pelanggan
    $('.edit-pelanggan').click(function() {
        var id = $(this).data('id');
        var kode = $(this).data('kode');
        var nama = $(this).data('nama');
        var alamat = $(this).data('alamat');
        var telepon = $(this).data('telepon');
        var email = $(this).data('email');
        
        $('#edit_id').val(id);
        $('#edit_kode_pelanggan').val(kode);
        $('#edit_nama_pelanggan').val(nama);
        $('#edit_alamat').val(alamat);
        $('#edit_telepon').val(telepon);
        $('#edit_email').val(email);
        
        $('#editPelangganModal').modal('show');
    });
});
</script>