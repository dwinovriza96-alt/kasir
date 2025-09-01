<?php
$current_page = 'produk';
$page_title = 'Data Produk';
include_once '../includes/header.php';
include_once '../includes/sidebar.php';
include_once '../includes/navitop.php';

// Ambil data produk dengan join kategori dan satuan
$query = mysqli_query($koneksi, "SELECT p.*, k.nama_kategori, s.nama_satuan 
                                FROM produk p 
                                JOIN kategori k ON p.kategori_id = k.id 
                                JOIN satuan s ON p.satuan_id = s.id 
                                WHERE p.status = 'aktif' 
                                ORDER BY p.nama_produk");
?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Produk</h1>
        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambahProdukModal">
            <i class="fas fa-plus fa-sm"></i> Tambah Produk
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
            <h6 class="m-0 font-weight-bold text-primary">Daftar Produk</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Kode</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Satuan</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            <th>Stok</th>
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
                                <td><?php echo $data['kode_produk']; ?></td>
                                <td><?php echo $data['nama_produk']; ?></td>
                                <td><?php echo $data['nama_kategori']; ?></td>
                                <td><?php echo $data['nama_satuan']; ?></td>
                                <td>Rp <?php echo number_format($data['harga_beli'], 0, ',', '.'); ?></td>
                                <td>Rp <?php echo number_format($data['harga_jual'], 0, ',', '.'); ?></td>
                                <td>
                                    <span class="badge <?php echo ($data['stok'] <= $data['minimal_stok']) ? 'badge-warning' : 'badge-success'; ?>">
                                        <?php echo $data['stok']; ?>
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-warning edit-produk" 
                                            data-id="<?php echo $data['id']; ?>" 
                                            data-kode="<?php echo $data['kode_produk']; ?>" 
                                            data-nama="<?php echo $data['nama_produk']; ?>" 
                                            data-kategori="<?php echo $data['kategori_id']; ?>" 
                                            data-satuan="<?php echo $data['satuan_id']; ?>" 
                                            data-hargabeli="<?php echo $data['harga_beli']; ?>" 
                                            data-hargajual="<?php echo $data['harga_jual']; ?>" 
                                            data-stok="<?php echo $data['stok']; ?>" 
                                            data-minimalstok="<?php echo $data['minimal_stok']; ?>">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <a href="../actions/produk_actions.php?hapus_produk=true&id=<?php echo $data['id']; ?>" 
                                       class="btn btn-sm btn-danger" 
                                       onclick="return confirm('Yakin ingin menghapus produk ini?')">
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

<!-- Modal Tambah Produk -->
<div class="modal fade" id="tambahProdukModal" tabindex="-1" role="dialog" aria-labelledby="tambahProdukModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahProdukModalLabel">Tambah Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="../actions/produk_actions.php" method="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kode_produk">Kode Produk</label>
                                <input type="text" class="form-control" id="kode_produk" name="kode_produk" value="PRD<?php echo date('YmdHis'); ?>" required readonly>
                            </div>
                            <div class="form-group">
                                <label for="nama_produk">Nama Produk</label>
                                <input type="text" class="form-control" id="nama_produk" name="nama_produk" required>
                            </div>
                            <div class="form-group">
                                <label for="kategori_id">Kategori</label>
                                <select class="form-control" id="kategori_id" name="kategori_id" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <?php
                                    $query_kategori = mysqli_query($koneksi, "SELECT * FROM kategori WHERE status = 'aktif' ORDER BY nama_kategori");
                                    while ($kategori = mysqli_fetch_array($query_kategori)) {
                                        echo "<option value='".$kategori['id']."'>".$kategori['nama_kategori']."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="satuan_id">Satuan</label>
                                <select class="form-control" id="satuan_id" name="satuan_id" required>
                                    <option value="">-- Pilih Satuan --</option>
                                    <?php
                                    $query_satuan = mysqli_query($koneksi, "SELECT * FROM satuan WHERE status = 'aktif' ORDER BY nama_satuan");
                                    while ($satuan = mysqli_fetch_array($query_satuan)) {
                                        echo "<option value='".$satuan['id']."'>".$satuan['nama_satuan']."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="harga_beli">Harga Beli</label>
                                <input type="number" class="form-control" id="harga_beli" name="harga_beli" required min="0">
                            </div>
                            <div class="form-group">
                                <label for="harga_jual">Harga Jual</label>
                                <input type="number" class="form-control" id="harga_jual" name="harga_jual" required min="0">
                            </div>
                            <div class="form-group">
                                <label for="stok">Stok</label>
                                <input type="number" class="form-control" id="stok" name="stok" required min="0">
                            </div>
                            <div class="form-group">
                                <label for="minimal_stok">Minimal Stok</label>
                                <input type="number" class="form-control" id="minimal_stok" name="minimal_stok" value="5" required min="1">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" name="tambah_produk" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Produk -->
<div class="modal fade" id="editProdukModal" tabindex="-1" role="dialog" aria-labelledby="editProdukModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProdukModalLabel">Edit Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="../actions/produk_actions.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" id="edit_id" name="id">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_kode_produk">Kode Produk</label>
                                <input type="text" class="form-control" id="edit_kode_produk" name="kode_produk" required readonly>
                            </div>
                            <div class="form-group">
                                <label for="edit_nama_produk">Nama Produk</label>
                                <input type="text" class="form-control" id="edit_nama_produk" name="nama_produk" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_kategori_id">Kategori</label>
                                <select class="form-control" id="edit_kategori_id" name="kategori_id" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <?php
                                    $query_kategori = mysqli_query($koneksi, "SELECT * FROM kategori WHERE status = 'aktif' ORDER BY nama_kategori");
                                    while ($kategori = mysqli_fetch_array($query_kategori)) {
                                        echo "<option value='".$kategori['id']."'>".$kategori['nama_kategori']."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="edit_satuan_id">Satuan</label>
                                <select class="form-control" id="edit_satuan_id" name="satuan_id" required>
                                    <option value="">-- Pilih Satuan --</option>
                                    <?php
                                    $query_satuan = mysqli_query($koneksi, "SELECT * FROM satuan WHERE status = 'aktif' ORDER BY nama_satuan");
                                    while ($satuan = mysqli_fetch_array($query_satuan)) {
                                        echo "<option value='".$satuan['id']."'>".$satuan['nama_satuan']."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_harga_beli">Harga Beli</label>
                                <input type="number" class="form-control" id="edit_harga_beli" name="harga_beli" required min="0">
                            </div>
                            <div class="form-group">
                                <label for="edit_harga_jual">Harga Jual</label>
                                <input type="number" class="form-control" id="edit_harga_jual" name="harga_jual" required min="0">
                            </div>
                            <div class="form-group">
                                <label for="edit_stok">Stok</label>
                                <input type="number" class="form-control" id="edit_stok" name="stok" required min="0">
                            </div>
                            <div class="form-group">
                                <label for="edit_minimal_stok">Minimal Stok</label>
                                <input type="number" class="form-control" id="edit_minimal_stok" name="minimal_stok" required min="1">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" name="edit_produk" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once '../includes/footer.php'; ?>

<script>
$(document).ready(function() {
    // Edit produk
    $('.edit-produk').click(function() {
        var id = $(this).data('id');
        var kode = $(this).data('kode');
        var nama = $(this).data('nama');
        var kategori = $(this).data('kategori');
        var satuan = $(this).data('satuan');
        var hargabeli = $(this).data('hargabeli');
        var hargajual = $(this).data('hargajual');
        var stok = $(this).data('stok');
        var minimalstok = $(this).data('minimalstok');
        
        $('#edit_id').val(id);
        $('#edit_kode_produk').val(kode);
        $('#edit_nama_produk').val(nama);
        $('#edit_kategori_id').val(kategori);
        $('#edit_satuan_id').val(satuan);
        $('#edit_harga_beli').val(hargabeli);
        $('#edit_harga_jual').val(hargajual);
        $('#edit_stok').val(stok);
        $('#edit_minimal_stok').val(minimalstok);
        
        $('#editProdukModal').modal('show');
    });
});
</script>