<?php
$current_page = 'pengaturan';
$page_title = 'Pengaturan Aplikasi';
include_once '../includes/header.php';
include_once '../includes/sidebar.php';
include_once '../includes/navitop.php';

// Ambil data pengaturan
$query = mysqli_query($koneksi, "SELECT * FROM pengaturan WHERE id = 1");
$pengaturan = mysqli_fetch_assoc($query);
?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pengaturan Aplikasi</h1>
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
            <h6 class="m-0 font-weight-bold text-primary">Pengaturan Umum</h6>
        </div>
        <div class="card-body">
            <form action="../actions/pengaturan_actions.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="logo_lama" value="<?php echo $pengaturan['logo_aplikasi']; ?>">
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama_aplikasi">Nama Aplikasi</label>
                            <input type="text" class="form-control" id="nama_aplikasi" name="nama_aplikasi" value="<?php echo $pengaturan['nama_aplikasi']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="logo_aplikasi">Logo Aplikasi</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="logo_aplikasi" name="logo_aplikasi" accept="image/*">
                                <label class="custom-file-label" for="logo_aplikasi">Pilih file...</label>
                            </div>
                            <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah logo</small>
                        </div>
                        <div class="form-group">
                            <label>Logo Saat Ini</label><br>
                            <img src="../assets/images/<?php echo $pengaturan['logo_aplikasi']; ?>" alt="Logo Aplikasi" width="100" class="img-thumbnail">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama_bisnis">Nama Bisnis</label>
                            <input type="text" class="form-control" id="nama_bisnis" name="nama_bisnis" value="<?php echo $pengaturan['nama_bisnis']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="alamat_bisnis">Alamat Bisnis</label>
                            <textarea class="form-control" id="alamat_bisnis" name="alamat_bisnis" rows="3"><?php echo $pengaturan['alamat_bisnis']; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="telepon_bisnis">Telepon Bisnis</label>
                            <input type="text" class="form-control" id="telepon_bisnis" name="telepon_bisnis" value="<?php echo $pengaturan['telepon_bisnis']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="footer_text">Footer Text</label>
                            <input type="text" class="form-control" id="footer_text" name="footer_text" value="<?php echo $pengaturan['footer_text']; ?>">
                        </div>
                    </div>
                </div>
                
                <button type="submit" name="update_pengaturan" class="btn btn-primary">Simpan Pengaturan</button>
            </form>
        </div>
    </div>
</div>

<?php include_once '../includes/footer.php'; ?>

<script>
// Menampilkan nama file yang dipilih di input file
document.querySelector('.custom-file-input').addEventListener('change', function(e) {
    var fileName = document.getElementById("logo_aplikasi").files[0].name;
    var nextSibling = e.target.nextElementSibling;
    nextSibling.innerText = fileName;
});
</script>