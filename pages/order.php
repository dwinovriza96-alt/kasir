<?php
$current_page = 'order';
$page_title = 'Order Penjualan';
include_once '../includes/header.php';
include_once '../includes/sidebar.php';
include_once '../includes/navitop.php';

// Generate kode transaksi
$kode_transaksi = 'TRX' . date('YmdHis');
?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Order Penjualan</h1>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Produk</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama Produk</th>
                                    <th>Kategori</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = mysqli_query($koneksi, "SELECT produk.*, kategori.nama_kategori 
                                                                FROM produk 
                                                                JOIN kategori ON produk.kategori_id = kategori.id 
                                                                WHERE produk.status = 'aktif' 
                                                                ORDER BY produk.nama_produk");
                                while ($data = mysqli_fetch_array($query)) {
                                ?>
                                    <tr>
                                        <td><?php echo $data['kode_produk']; ?></td>
                                        <td><?php echo $data['nama_produk']; ?></td>
                                        <td><?php echo $data['nama_kategori']; ?></td>
                                        <td>Rp <?php echo number_format($data['harga_jual'], 0, ',', '.'); ?></td>
                                        <td><?php echo $data['stok']; ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-primary add-to-cart" 
                                                    data-id="<?php echo $data['id']; ?>" 
                                                    data-kode="<?php echo $data['kode_produk']; ?>" 
                                                    data-nama="<?php echo $data['nama_produk']; ?>" 
                                                    data-harga="<?php echo $data['harga_jual']; ?>" 
                                                    data-stok="<?php echo $data['stok']; ?>">
                                                <i class="fas fa-cart-plus"></i> Tambah
                                            </button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Keranjang Belanja</h6>
                </div>
                <div class="card-body">
                    <form id="form-transaksi" action="../actions/order_actions.php" method="POST">
                        <input type="hidden" name="kode_transaksi" value="<?php echo $kode_transaksi; ?>">
                        
                        <div class="form-group">
                            <label>Pelanggan</label>
                            <select class="form-control" name="pelanggan_id" id="pelanggan_id">
                                <option value="">-- Pilih Pelanggan --</option>
                                <?php
                                $query_pelanggan = mysqli_query($koneksi, "SELECT * FROM pelanggan WHERE status = 'aktif' ORDER BY nama_pelanggan");
                                while ($pelanggan = mysqli_fetch_array($query_pelanggan)) {
                                    echo "<option value='".$pelanggan['id']."'>".$pelanggan['nama_pelanggan']."</option>";
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-bordered" id="keranjang">
                                <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th width="80">Qty</th>
                                        <th>Harga</th>
                                        <th>Subtotal</th>
                                        <th width="50">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Items will be added here via JavaScript -->
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3">Total</th>
                                        <th id="total-bayar">Rp 0</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        
                        <div class="form-group">
                            <label>Diskon (Rp)</label>
                            <input type="number" class="form-control" name="diskon" id="diskon" value="0" min="0">
                        </div>
                        
                        <div class="form-group">
                            <label>Total Bayar</label>
                            <input type="text" class="form-control" name="total_bayar" id="total_bayar" readonly value="0">
                        </div>
                        
                        <div class="form-group">
                            <label>Tunai (Rp)</label>
                            <input type="number" class="form-control" name="tunai" id="tunai" value="0" min="0" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Kembalian</label>
                            <input type="text" class="form-control" name="kembalian" id="kembalian" readonly value="0">
                        </div>
                        
                        <div class="form-group">
                            <label>Catatan</label>
                            <textarea class="form-control" name="catatan" rows="2"></textarea>
                        </div>
                        
                        <button type="submit" name="proses_transaksi" class="btn btn-success btn-block">
                            <i class="fas fa-check"></i> Proses Transaksi
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once '../includes/footer.php'; ?>

<script>
$(document).ready(function() {
    let cart = [];
    
    // Add to cart
    $('.add-to-cart').click(function() {
        const id = $(this).data('id');
        const kode = $(this).data('kode');
        const nama = $(this).data('nama');
        const harga = $(this).data('harga');
        const stok = $(this).data('stok');
        
        // Check if product already in cart
        const existingItem = cart.find(item => item.id === id);
        
        if (existingItem) {
            if (existingItem.qty < stok) {
                existingItem.qty++;
                existingItem.subtotal = existingItem.qty * existingItem.harga;
            } else {
                alert('Stok tidak mencukupi!');
            }
        } else {
            if (stok > 0) {
                cart.push({
                    id: id,
                    kode: kode,
                    nama: nama,
                    harga: harga,
                    qty: 1,
                    subtotal: harga
                });
            } else {
                alert('Stok habis!');
            }
        }
        
        updateCart();
    });
    
    // Remove from cart
    $(document).on('click', '.remove-from-cart', function() {
        const index = $(this).data('index');
        cart.splice(index, 1);
        updateCart();
    });
    
    // Update quantity
    $(document).on('change', '.qty-input', function() {
        const index = $(this).data('index');
        const newQty = parseInt($(this).val());
        
        if (newQty > 0) {
            cart[index].qty = newQty;
            cart[index].subtotal = cart[index].qty * cart[index].harga;
            updateCart();
        }
    });
    
    // Calculate totals
    $('#diskon, #tunai').on('input', function() {
        calculateTotals();
    });
    
    // Update cart display
    function updateCart() {
        const cartTable = $('#keranjang tbody');
        cartTable.empty();
        
        cart.forEach((item, index) => {
            cartTable.append(`
                <tr>
                    <td>${item.nama}</td>
                    <td>
                        <input type="number" class="form-control form-control-sm qty-input" 
                               data-index="${index}" value="${item.qty}" min="1">
                    </td>
                    <td>Rp ${item.harga.toLocaleString()}</td>
                    <td>Rp ${item.subtotal.toLocaleString()}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-danger remove-from-cart" data-index="${index}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `);
        });
        
        calculateTotals();
    }
    
    // Calculate totals
    function calculateTotals() {
        const total = cart.reduce((sum, item) => sum + item.subtotal, 0);
        const diskon = parseInt($('#diskon').val()) || 0;
        const totalBayar = total - diskon;
        const tunai = parseInt($('#tunai').val()) || 0;
        const kembalian = tunai - totalBayar;
        
        $('#total-bayar').text('Rp ' + total.toLocaleString());
        $('#total_bayar').val(totalBayar);
        $('#kembalian').val(kembalian);
        
        // Update hidden fields for form submission
        $('input[name="cart_items"]').remove();
        cart.forEach((item, index) => {
            $('#form-transaksi').append(`
                <input type="hidden" name="cart[${index}][produk_id]" value="${item.id}">
                <input type="hidden" name="cart[${index}][harga]" value="${item.harga}">
                <input type="hidden" name="cart[${index}][jumlah]" value="${item.qty}">
                <input type="hidden" name="cart[${index}][sub_total]" value="${item.subtotal}">
            `);
        });
    }
});
</script>