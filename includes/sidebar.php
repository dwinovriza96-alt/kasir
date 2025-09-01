<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon">
            <img src="../assets/images/<?php echo $pengaturan['logo_aplikasi']; ?>" width="40" height="40">
        </div>
        <div class="sidebar-brand-text mx-3"><?php echo $pengaturan['nama_aplikasi']; ?></div>
    </a>

    <hr class="sidebar-divider my-0">

    <li class="nav-item <?php echo ($current_page == 'dashboard') ? 'active' : ''; ?>">
        <a class="nav-link" href="../index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Transaksi
    </div>

    <li class="nav-item <?php echo ($current_page == 'order') ? 'active' : ''; ?>">
        <a class="nav-link" href="../pages/order.php">
            <i class="fas fa-fw fa-shopping-cart"></i>
            <span>Order Penjualan</span></a>
    </li>

    <li class="nav-item <?php echo ($current_page == 'transaksi') ? 'active' : ''; ?>">
        <a class="nav-link" href="../pages/transaksi.php">
            <i class="fas fa-fw fa-file-invoice"></i>
            <span>Data Transaksi</span></a>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Data Master
    </div>

    <li class="nav-item <?php echo ($current_page == 'pelanggan') ? 'active' : ''; ?>">
        <a class="nav-link" href="../pages/pelanggan.php">
            <i class="fas fa-fw fa-users"></i>
            <span>Pelanggan</span></a>
    </li>

    <li class="nav-item <?php echo ($current_page == 'produk') ? 'active' : ''; ?>">
        <a class="nav-link" href="../pages/produk.php">
            <i class="fas fa-fw fa-box"></i>
            <span>Produk</span></a>
    </li>

    <li class="nav-item <?php echo ($current_page == 'kategori') ? 'active' : ''; ?>">
        <a class="nav-link" href="../pages/kategori.php">
            <i class="fas fa-fw fa-tags"></i>
            <span>Kategori</span></a>
    </li>

    <li class="nav-item <?php echo ($current_page == 'satuan') ? 'active' : ''; ?>">
        <a class="nav-link" href="../pages/satuan.php">
            <i class="fas fa-fw fa-balance-scale"></i>
            <span>Satuan</span></a>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Pengaturan
    </div>

    <li class="nav-item <?php echo ($current_page == 'pengguna') ? 'active' : ''; ?>">
        <a class="nav-link" href="../pages/pengguna.php">
            <i class="fas fa-fw fa-user-cog"></i>
            <span>Pengguna</span></a>
    </li>

    <li class="nav-item <?php echo ($current_page == 'pengaturan') ? 'active' : ''; ?>">
        <a class="nav-link" href="../pages/pengaturan.php">
            <i class="fas fa-fw fa-cog"></i>
            <span>Pengaturan Aplikasi</span></a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>