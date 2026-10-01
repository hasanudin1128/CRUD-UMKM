<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../config/database.php';

// Hitung total produk
$total_produk_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM produk");
$data_produk = mysqli_fetch_assoc($total_produk_query);

// Hitung total kategori
$total_kategori_query = mysqli_query($conn, "SELECT COUNT(DISTINCT kategori) AS total FROM produk");
$data_kategori = mysqli_fetch_assoc($total_kategori_query);

$admin_nama = $_SESSION['admin_nama'] ?? 'Administrator';
$admin_username = $_SESSION['admin_username'] ?? 'admin';
$initial = strtoupper(substr($admin_nama, 0, 1));
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - BondoRoso</title>

    <!-- GOOGLE FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@600;700&display=swap" rel="stylesheet">

    <!-- FONT AWESOME 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --bg-body: #0b132b;
            --bg-sidebar: #0f172a;
            --bg-card: rgba(30, 41, 59, 0.7);
            --bg-card-hover: rgba(30, 41, 59, 0.9);
            --border-color: rgba(255, 255, 255, 0.08);
            --border-highlight: rgba(59, 130, 246, 0.3);
            
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
            
            --accent-blue: #3b82f6;
            --accent-blue-hover: #2563eb;
            --accent-indigo: #6366f1;
            --accent-glow: rgba(59, 130, 246, 0.25);
            
            --success: #10b981;
            --success-bg: rgba(16, 185, 129, 0.12);
            --warning: #f59e0b;
            --warning-bg: rgba(245, 158, 11, 0.12);
            --danger: #ef4444;
            --danger-bg: rgba(239, 68, 68, 0.12);

            --transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            --radius-sm: 12px;
            --radius-md: 18px;
            --radius-lg: 24px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-body);
            background-image: 
                radial-gradient(circle at 10% 10%, rgba(30, 58, 138, 0.25) 0%, transparent 40%),
                radial-gradient(circle at 90% 90%, rgba(15, 23, 42, 0.8) 0%, transparent 40%);
            background-attachment: fixed;
            color: var(--text-primary);
            display: flex;
            min-height: 100vh;
        }

        /* -----------------------------------------------------------------
           SIDEBAR DESIGN
        ----------------------------------------------------------------- */
        .sidebar {
            width: 270px;
            background: var(--bg-sidebar);
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            transition: var(--transition);
        }

        .sidebar-brand {
            padding: 30px 24px;
            display: flex;
            align-items: center;
            gap: 14px;
            text-decoration: none;
            border-bottom: 1px solid var(--border-color);
        }

        .brand-icon {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, var(--accent-blue) 0%, var(--accent-indigo) 100%);
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 20px;
            box-shadow: 0 8px 16px var(--accent-glow);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .brand-text h2 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 20px;
            font-weight: 700;
            color: #ffffff;
            line-height: 1.2;
        }

        .brand-text span {
            font-size: 11px;
            color: var(--accent-blue);
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .sidebar-menu {
            list-style: none;
            padding: 24px 16px;
            display: flex;
            flex-direction: column;
            gap: 8px;
            flex-grow: 1;
        }

        .menu-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-muted);
            padding: 8px 12px 4px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 16px;
            color: var(--text-secondary);
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            border-radius: var(--radius-sm);
            transition: var(--transition);
            position: relative;
        }

        .sidebar-menu a i {
            font-size: 16px;
            width: 20px;
            text-align: center;
            transition: var(--transition);
        }

        .sidebar-menu a:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.05);
        }

        .sidebar-menu a.active {
            background: linear-gradient(90deg, rgba(59, 130, 246, 0.15) 0%, rgba(59, 130, 246, 0.03) 100%);
            color: var(--accent-blue);
            border-left: 3px solid var(--accent-blue);
            border-radius: 0 var(--radius-sm) var(--radius-sm) 0;
        }

        .sidebar-menu a.active i {
            color: var(--accent-blue);
        }

        .sidebar-footer {
            padding: 20px 16px;
            border-top: 1px solid var(--border-color);
        }

        .btn-logout {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 12px 18px;
            color: var(--danger);
            background: var(--danger-bg);
            border: 1px solid rgba(239, 68, 68, 0.2);
            text-decoration: none;
            font-weight: 700;
            font-size: 13px;
            border-radius: var(--radius-sm);
            transition: var(--transition);
        }

        .btn-logout:hover {
            background: var(--danger);
            color: #ffffff;
            box-shadow: 0 8px 16px rgba(239, 68, 68, 0.3);
        }

        /* -----------------------------------------------------------------
           MAIN CONTENT LAYOUT
        ----------------------------------------------------------------- */
        .main-wrapper {
            margin-left: 270px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .top-header {
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            padding: 18px 40px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 90;
        }

        .header-title h3 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 18px;
            font-weight: 700;
            color: #ffffff;
        }

        .header-title p {
            font-size: 12px;
            color: var(--text-secondary);
        }

        .admin-profile {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 6px 12px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border-color);
            border-radius: 50px;
        }

        .avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 15px;
            box-shadow: 0 4px 10px var(--accent-glow);
        }

        .admin-info h4 {
            font-size: 13px;
            font-weight: 700;
            color: #ffffff;
            line-height: 1.2;
        }

        .admin-info p {
            font-size: 11px;
            color: var(--text-secondary);
        }

        .content-body {
            padding: 36px 40px;
            flex-grow: 1;
        }

        /* -----------------------------------------------------------------
           WELCOME BANNER
        ----------------------------------------------------------------- */
        .welcome-banner {
            position: relative;
            background: linear-gradient(135deg, rgba(30, 58, 138, 0.6) 0%, rgba(15, 23, 42, 0.8) 100%);
            border-radius: var(--radius-lg);
            padding: 36px 40px;
            margin-bottom: 32px;
            border: 1px solid var(--border-highlight);
            backdrop-filter: blur(12px);
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        .welcome-banner::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 220px;
            height: 220px;
            background: rgba(59, 130, 246, 0.2);
            border-radius: 50%;
            filter: blur(50px);
        }

        .welcome-content {
            position: relative;
            z-index: 2;
            max-width: 650px;
        }

        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            background: rgba(59, 130, 246, 0.15);
            border: 1px solid rgba(59, 130, 246, 0.3);
            color: #60a5fa;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 16px;
        }

        .welcome-banner h1 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 30px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 10px;
            line-height: 1.2;
        }

        .welcome-banner p {
            color: var(--text-secondary);
            font-size: 14px;
            line-height: 1.6;
        }

        /* -----------------------------------------------------------------
           METRICS GRID
        ----------------------------------------------------------------- */
        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 24px;
            margin-bottom: 32px;
        }

        .metric-card {
            background: var(--bg-card);
            backdrop-filter: blur(16px);
            border-radius: var(--radius-md);
            padding: 26px;
            border: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: var(--transition);
        }

        .metric-card:hover {
            background: var(--bg-card-hover);
            transform: translateY(-4px);
            border-color: rgba(255, 255, 255, 0.15);
            box-shadow: 0 16px 30px rgba(0, 0, 0, 0.3);
        }

        .metric-details h3 {
            font-size: 12px;
            font-weight: 700;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 8px;
        }

        .metric-details .value {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 32px;
            font-weight: 700;
            color: #ffffff;
            line-height: 1;
        }

        .metric-icon {
            width: 58px;
            height: 58px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .metric-icon.blue {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.2) 0%, rgba(37, 99, 235, 0.3) 100%);
            color: #60a5fa;
            border-color: rgba(59, 130, 246, 0.3);
        }

        .metric-icon.amber {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.2) 0%, rgba(217, 119, 6, 0.3) 100%);
            color: #fbbf24;
            border-color: rgba(245, 158, 11, 0.3);
        }

        .metric-icon.emerald {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.2) 0%, rgba(5, 150, 105, 0.3) 100%);
            color: #34d399;
            border-color: rgba(16, 185, 129, 0.3);
        }

        /* -----------------------------------------------------------------
           ACTION CARDS GRID
        ----------------------------------------------------------------- */
        .actions-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 24px;
        }

        .action-card {
            background: var(--bg-card);
            backdrop-filter: blur(16px);
            border-radius: var(--radius-lg);
            padding: 30px;
            border: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 24px;
        }

        .action-card-text h2 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 20px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 6px;
        }

        .action-card-text p {
            color: var(--text-secondary);
            font-size: 13px;
            line-height: 1.5;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 14px 24px;
            background: linear-gradient(135deg, var(--accent-blue) 0%, var(--accent-blue-hover) 100%);
            color: #ffffff;
            text-decoration: none;
            font-weight: 700;
            font-size: 14px;
            border-radius: var(--radius-sm);
            transition: var(--transition);
            box-shadow: 0 10px 20px var(--accent-glow);
            white-space: nowrap;
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 28px rgba(59, 130, 246, 0.4);
            background: linear-gradient(135deg, #60a5fa 0%, var(--accent-blue) 100%);
        }

        .system-info-card {
            background: var(--bg-card);
            backdrop-filter: blur(16px);
            border-radius: var(--radius-lg);
            padding: 26px;
            border: 1px solid var(--border-color);
        }

        .system-info-card h4 {
            font-size: 14px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .info-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
        }

        .info-item .label {
            color: var(--text-muted);
        }

        .info-item .val {
            color: var(--text-primary);
            font-weight: 600;
        }

        /* -----------------------------------------------------------------
           RESPONSIVE DESIGN
        ----------------------------------------------------------------- */
        @media (max-width: 1024px) {
            .actions-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 992px) {
            .sidebar {
                width: 80px;
            }
            .sidebar-brand {
                justify-content: center;
                padding: 20px 10px;
            }
            .brand-text, .menu-label, .sidebar-menu span, .btn-logout span, .admin-info {
                display: none;
            }
            .main-wrapper {
                margin-left: 80px;
            }
            .sidebar-menu a {
                justify-content: center;
                padding: 16px;
            }
            .sidebar-menu a.active {
                border-left: none;
                border-bottom: 3px solid var(--accent-blue);
                border-radius: var(--radius-sm);
            }
        }

        @media (max-width: 576px) {
            .top-header, .content-body {
                padding: 20px;
            }
            .welcome-banner {
                padding: 24px;
            }
            .action-card {
                flex-direction: column;
                align-items: flex-start;
            }
            .btn-primary {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>

<body>

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <a href="index.php" class="sidebar-brand">
            <div class="brand-icon">
                <i class="fa-solid fa-cake-candles"></i>
            </div>
            <div class="brand-text">
                <h2>BondoRoso</h2>
                <span>Admin Panel</span>
            </div>
        </a>

        <ul class="sidebar-menu">
            <li class="menu-label">Navigasi Utama</li>
            <li>
                <a href="index.php" class="active">
                    <i class="fa-solid fa-chart-pie"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="produk.php">
                    <i class="fa-solid fa-boxes-stacked"></i>
                    <span>Kelola Produk</span>
                </a>
            </li>

            <li class="menu-label">Situs Web</li>
            <li>
                <a href="../index.php" target="_blank">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                    <span>Lihat Website</span>
                </a>
            </li>
        </ul>

        <div class="sidebar-footer">
            <a href="logout.php" class="btn-logout">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span>Logout Keluar</span>
            </a>
        </div>
    </aside>

    <!-- MAIN WRAPPER -->
    <div class="main-wrapper">

        <!-- TOP HEADER -->
        <header class="top-header">
            <div class="header-title">
                <h3>Dashboard Panel</h3>
                <p>Selamat bertugas, kelola toko dengan efisien.</p>
            </div>

            <div class="admin-profile">
                <div class="avatar">
                    <?= htmlspecialchars($initial); ?>
                </div>
                <div class="admin-info">
                    <h4><?= htmlspecialchars($admin_nama); ?></h4>
                    <p>@<?= htmlspecialchars($admin_username); ?></p>
                </div>
            </div>
        </header>

        <!-- MAIN CONTENT BODY -->
        <main class="content-body">

            <!-- WELCOME BANNER -->
            <div class="welcome-banner">
                <div class="welcome-content">
                    <div class="badge-status">
                        <i class="fa-solid fa-circle-check"></i> System Operational
                    </div>
                    <h1>Selamat Datang Kembali, <?= htmlspecialchars($admin_nama); ?>! 👋</h1>
                    <p>Ringkasan statistik produk dan opsi manajemen cepat toko kue Anda dapat diakses langsung melalui panel kontrol ini.</p>
                </div>
            </div>

            <!-- METRICS CARDS -->
            <div class="metrics-grid">
                <div class="metric-card">
                    <div class="metric-details">
                        <h3>Total Produk</h3>
                        <div class="value"><?= number_format($data_produk['total'] ?? 0); ?></div>
                    </div>
                    <div class="metric-icon blue">
                        <i class="fa-solid fa-cake-candles"></i>
                    </div>
                </div>

                <div class="metric-card">
                    <div class="metric-details">
                        <h3>Total Kategori</h3>
                        <div class="value"><?= number_format($data_kategori['total'] ?? 0); ?></div>
                    </div>
                    <div class="metric-icon amber">
                        <i class="fa-solid fa-layer-group"></i>
                    </div>
                </div>

                <div class="metric-card">
                    <div class="metric-details">
                        <h3>Status Server</h3>
                        <div class="value" style="font-size: 20px; color: #34d399; margin-top: 6px;">Online</div>
                    </div>
                    <div class="metric-icon emerald">
                        <i class="fa-solid fa-server"></i>
                    </div>
                </div>
            </div>

            <!-- ACTIONS & SYSTEM INFO GRID -->
            <div class="actions-grid">
                <div class="action-card">
                    <div class="action-card-text">
                        <h2>Manajemen Katalog Produk</h2>
                        <p>Tambah menu cake baru, atur variasi harga, edit ketersediaan, atau perbarui data produk yang ada di website.</p>
                    </div>
                    <a href="produk.php" class="btn-primary">
                        <i class="fa-solid fa-boxes-stacked"></i> Kelola Produk
                    </a>
                </div>

                <div class="system-info-card">
                    <h4><i class="fa-solid fa-circle-info" style="color: var(--accent-blue);"></i> Informasi Ringkas</h4>
                    <div class="info-list">
                        <div class="info-item">
                            <span class="label">Versi PHP</span>
                            <span class="val"><?= PHP_VERSION; ?></span>
                        </div>
                        <div class="info-item">
                            <span class="label">Database</span>
                            <span class="val">MySQLi Connected</span>
                        </div>
                        <div class="info-item">
                            <span class="label">Waktu Sistem</span>
                            <span class="val"><?= date('H:i T'); ?></span>
                        </div>
                    </div>
                </div>
            </div>

        </main>

    </div>

</body>

</html>