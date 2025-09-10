<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kasir</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #4895ef;
            --text-color: #333;
            --text-light: #6c757d;
            --bg-light: #f8f9fa;
            --border-color: #dee2e6;
            --sidebar-width: 250px;
            --header-height: 60px;
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f7fb;
            color: var(--text-color);
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(to bottom, var(--primary-color), var(--secondary-color));
            color: white;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            overflow-y: auto;
            transition: var(--transition);
            z-index: 1000;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .sidebar-header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-header h3 {
            font-weight: 600;
            font-size: 1.4rem;
            margin: 10px 0 5px;
        }

        .sidebar-header p {
            font-size: 0.85rem;
            opacity: 0.8;
        }

        .sidebar-menu {
            padding: 15px 0;
        }

        .menu-category {
            padding: 10px 20px;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.7;
            margin-top: 15px;
        }

        .menu-item {
            padding: 12px 20px;
            display: flex;
            align-items: center;
            transition: var(--transition);
            cursor: pointer;
            border-left: 4px solid transparent;
        }

        .menu-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-left: 4px solid var(--accent-color);
        }

        .menu-item.active {
            background-color: rgba(255, 255, 255, 0.15);
            border-left: 4px solid white;
        }

        .menu-item i {
            margin-right: 12px;
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }

        .menu-item span {
            flex: 1;
        }

        .sub-menu {
            padding-left: 20px;
            max-height: 0;
            overflow: hidden;
            transition: var(--transition);
        }

        .sub-menu.open {
            max-height: 500px;
        }

        .sub-menu .menu-item {
            padding: 10px 20px 10px 50px;
            font-size: 0.9rem;
        }

        .sidebar-footer {
            padding: 15px 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: 20px;
            font-size: 0.8rem;
            opacity: 0.7;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            padding: 20px;
            transition: var(--transition);
        }

        .header {
            background-color: white;
            padding: 15px 25px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            font-size: 1.8rem;
            color: var(--primary-color);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        .dashboard-content {
            background-color: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .dashboard-content h2 {
            margin-bottom: 20px;
            color: var(--secondary-color);
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
                width: 220px;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .menu-toggle {
                display: block;
            }
        }

        .menu-toggle {
            display: none;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 5px;
            padding: 8px 12px;
            cursor: pointer;
            font-size: 1.2rem;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h3>Sistem Kasir</h3>
            <p>Point of Sale Application</p>
        </div>

        <div class="sidebar-menu">
            <div class="menu-category">Main Menu</div>
            
            <div class="menu-item active">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </div>

            <div class="menu-category">Transaksi</div>
            
            <div class="menu-item">
                <i class="fas fa-exchange-alt"></i>
                <span>Transaksi</span>
            </div>
            
            <div class="menu-item">
                <i class="fas fa-shopping-cart"></i>
                <span>Order Penjualan</span>
            </div>
            
            <div class="menu-item">
                <i class="fas fa-database"></i>
                <span>Data Transaksi</span>
            </div>

            <div class="menu-category">Data Master</div>
            
            <div class="menu-item">
                <i class="fas fa-users"></i>
                <span>Pelanggan</span>
            </div>
            
            <div class="menu-item">
                <i class="fas fa-box"></i>
                <span>Produk</span>
            </div>
            
            <div class="menu-item">
                <i class="fas fa-tags"></i>
                <span>Kategori</span>
            </div>
            
            <div class="menu-item">
                <i class="fas fa-balance-scale"></i>
                <span>Satuan</span>
            </div>

            <div class="menu-category">Pengaturan</div>
            
            <div class="menu-item">
                <i class="fas fa-user-cog"></i>
                <span>Pengguna</span>
            </div>
            
            <div class="menu-item">
                <i class="fas fa-cog"></i>
                <span>Pengaturan Aplikasi</span>
            </div>
        </div>

        <div class="sidebar-footer">
            <p>localhost/kasir/space/index.php</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="header">
            <button class="menu-toggle" id="menuToggle">
                <i class="fas fa-bars"></i>
            </button>
            <h1>Dashboard</h1>
            <div class="user-info">
                <div class="user-avatar">A</div>
                <span>Admin</span>
            </div>
        </div>

        <div class="dashboard-content">
            <h2>Selamat Datang di Sistem Kasir</h2>
            <p>Ini adalah halaman dashboard untuk mengelola transaksi dan data master toko Anda.</p>
        </div>
    </div>

    <script>
        // Toggle sidebar on mobile
        document.getElementById('menuToggle').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('open');
        });

        // Add click event to menu items
        const menuItems = document.querySelectorAll('.menu-item');
        menuItems.forEach(item => {
            item.addEventListener('click', function() {
                // Remove active class from all items
                menuItems.forEach(i => i.classList.remove('active'));
                // Add active class to clicked item
                this.classList.add('active');
            });
        });
    </script>
</body>
</html>
