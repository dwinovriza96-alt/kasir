<?php
$current_page = 'pengguna';
$page_title = 'Data Pengguna';
include_once '../includes/header.php';
include_once '../includes/sidebar.php';
include_once '../includes/navitop.php';

// Ambil data pengguna
$query = mysqli_query($koneksi, "SELECT * FROM pengguna WHERE status = 'aktif' ORDER BY nama_lengkap");
?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Pengguna</h1>
        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambahPenggunaModal">
            <i class="fas fa-plus fa-sm"></i> Tambah Pengguna
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
            <h6 class="m-0 font-weight-bold text-primary">Daftar Pengguna</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Username</th>
                            <th>Nama Lengkap</th>
                            <th>Level</th>
                            <th>Tanggal Dibuat</th>
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
                                <td><?php echo $data['username']; ?></td>
                                <td><?php echo $data['nama_lengkap']; ?></td>
                                <td>
                                    <span class="badge <?php echo ($data['level'] == 'admin') ? 'badge-primary' : 'badge-secondary'; ?>">
                                        <?php echo ucfirst($data['level']); ?>
                                    </span>
                                </td>
                                <td><?php echo date('d/m/Y H:i', strtotime($data['tanggal_dibuat'])); ?></td>
                                <td>
                                    <button class="btn btn-sm btn-warning edit-pengguna" 
                                            data-id="<?php echo $data['id']; ?>" 
                                            data-username="<?php echo $data['username']; ?>" 
                                            data-nama="<?php echo $data['nama_lengkap']; ?>" 
                                            data-level="<?php echo $data['level']; ?>" 
                                            data-status="<?php echo $data['status']; ?>">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <?php if ($data['id'] != $_SESSION['user_id']): ?>
                                    <a href="../actions/pengguna_actions.php?hapus_pengguna=true&id=<?php echo $data['id']; ?>" 
                                       class="btn btn-sm btn-danger" 
                                       onclick="return confirm('Yakin ingin menghapus pengguna ini?')">
                                        <i class="fas fa-trash"></i>
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

<!-- Modal Tambah Pengguna -->
<div class="modal fade" id="tambahPenggunaModal" tabindex="-1" role="dialog" aria-labelledby="tambahPenggunaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahPenggunaModalLabel">Tambah Pengguna</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="../actions/pengguna_actions.php" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="nama_lengkap">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required>
                    </div>
                    <div class="form-group">
                        <label for="level">Level</label>
                        <select class="form-control" id="level" name="level" required>
                            <option value="kasir">Kasir</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" name="tambah_pengguna" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Pengguna -->
<div class="modal fade" id="editPenggunaModal" tabindex="-1" role="dialog" aria-labelledby="editPenggunaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPenggunaModalLabel">Edit Pengguna</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="../actions/pengguna_actions.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" id="edit_id" name="id">
                    <div class="form-group">
                        <label for="edit_username">Username</label>
                        <input type="text" class="form-control" id="edit_username" name="username" required readonly>
                    </div>
                    <div class="form-group">
                        <label for="edit_password">Password (Kosongkan jika tidak diubah)</label>
                        <input type="password" class="form-control" id="edit_password" name="password">
                    </div>
                    <div class="form-group">
                        <label for="edit_nama_lengkap">Nama Lengkap</label>
                        <input type="text" class="form-control" id="edit_nama_lengkap" name="nama_lengkap" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_level">Level</label>
                        <select class="form-control" id="edit_level" name="level" required>
                            <option value="kasir">Kasir</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_status">Status</label>
                        <select class="form-control" id="edit_status" name="status" required>
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" name="edit_pengguna" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once '../includes/footer.php'; ?>

<script>
$(document).ready(function() {
    // Edit pengguna
    $('.edit-pengguna').click(function() {
        var id = $(this).data('id');
        var username = $(this).data('username');
        var nama = $(this).data('nama');
        var level = $(this).data('level');
        var status = $(this).data('status');
        
        $('#edit_id').val(id);
        $('#edit_username').val(username);
        $('#edit_nama_lengkap').val(nama);
        $('#edit_level').val(level);
        $('#edit_status').val(status);
        
        $('#editPenggunaModal').modal('show');
    });
});
</script>