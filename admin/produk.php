<?php
session_start();

require_once __DIR__ . "/../includes/auth.php";
require_once __DIR__ . "/../config/database.php";

$keyword = $_GET['keyword'] ?? '';
$kategori = $_GET['kategori'] ?? '';

$where = [];

if ($keyword != '') {
    $keyword_safe = mysqli_real_escape_string($conn, $keyword);
    $where[] = "nama LIKE '%$keyword_safe%'";
}

if ($kategori != '') {
    $kategori_safe = mysqli_real_escape_string($conn, $kategori);
    $where[] = "kategori = '$kategori_safe'";
}

$where_sql = "";

if (count($where) > 0) {
    $where_sql = "WHERE " . implode(" AND ", $where);
}

/*
|--------------------------------------------------------------------------
| PAGINATION
|--------------------------------------------------------------------------
*/

$per_page = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

if ($page < 1) {
    $page = 1;
}

$offset = ($page - 1) * $per_page;

$count_query = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total 
    FROM produk
    $where_sql"
);

$count_data = mysqli_fetch_assoc($count_query);
$total_data = $count_data['total'];
$total_page = ceil($total_data / $per_page);

$query = mysqli_query(
    $conn,
    "SELECT * FROM produk
    $where_sql
    ORDER BY id DESC
    LIMIT $per_page OFFSET $offset"
);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Produk - BondoRoso Admin</title>

    <!-- Google Fonts & Font Awesome Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            /* Palette Navy Premium */
            --navy-darker: #090d16;
            --navy-dark: #0f172a;
            --navy-sidebar: #111a2e;
            --navy-primary: #1e3a8a;
            --navy-accent: #2563eb;
            --navy-light: #eff6ff;
            --navy-border: #cbd5e1;
            
            /* Warna Aksen Pendukung */
            --amber-accent: #d97706;
            --amber-bg: #fffbeb;
            --rose-accent: #e11d48;
            --rose-bg: #ffe4e6;
            
            /* Warna Dasar UI */
            --text-main: #1e293b;
            --text-muted: #64748b;
            --bg-body: #f8fafc;
            --white: #ffffff;
            
            /* Variabel Layout & Shadow */
            --shadow-sm: 0 1px 3px rgba(15, 23, 42, 0.08);
            --shadow-md: 0 4px 12px -2px rgba(15, 23, 42, 0.08);
            --shadow-lg: 0 12px 28px -4px rgba(15, 23, 42, 0.12);
            --radius-sm: 8px;
            --radius-md: 14px;
            --radius-lg: 20px;
            --transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styling (Deep Navy Gradient) */
        .sidebar {
            width: 280px;
            background: linear-gradient(180deg, var(--navy-dark) 0%, var(--navy-sidebar) 100%);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.12);
        }

        .sidebar-brand {
            padding: 28px 24px;
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: #f8fafc;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .sidebar-brand i {
            color: var(--amber-accent);
            font-size: 1.5rem;
            background: rgba(217, 119, 6, 0.15);
            padding: 10px;
            border-radius: 12px;
        }

        .sidebar-menu {
            list-style: none;
            padding: 24px 16px;
            display: flex;
            flex-direction: column;
            gap: 6px;
            flex-grow: 1;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 13px 18px;
            color: #94a3b8;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.92rem;
            border-radius: var(--radius-md);
            transition: var(--transition);
        }

        .sidebar-menu a:hover {
            background: rgba(255, 255, 255, 0.06);
            color: #f8fafc;
            transform: translateX(3px);
        }

        .sidebar-menu a.active {
            background: var(--navy-accent);
            color: var(--white);
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.35);
        }

        .sidebar-footer {
            padding: 20px 16px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .btn-logout {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 18px;
            color: #fca5a5;
            background: rgba(225, 29, 72, 0.1);
            text-decoration: none;
            font-weight: 700;
            font-size: 0.9rem;
            border-radius: var(--radius-md);
            transition: var(--transition);
        }

        .btn-logout:hover {
            background: var(--rose-accent);
            color: var(--white);
        }

        /* Main Content Wrapper */
        .main-wrapper {
            margin-left: 280px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Header Navigation */
        .top-header {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            padding: 18px 40px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 90;
        }

        .header-title-badge {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .header-title-badge h3 {
            font-size: 1.15rem;
            font-weight: 800;
            color: var(--navy-dark);
        }

        .admin-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 6px 14px;
            border-radius: 30px;
            background: var(--bg-body);
            border: 1px solid #e2e8f0;
        }

        .avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: var(--navy-primary);
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 1rem;
            box-shadow: 0 2px 6px rgba(30, 58, 138, 0.25);
        }

        .admin-info h4 {
            font-size: 0.88rem;
            font-weight: 700;
            color: var(--navy-dark);
            line-height: 1.2;
        }

        .admin-info p {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        .content-body {
            padding: 36px 40px;
            flex-grow: 1;
        }

        /* Header Halaman & Tombol Aksi */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 16px;
        }

        .page-title-group h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.1rem;
            color: var(--navy-dark);
            font-weight: 700;
        }

        .page-title-group p {
            font-size: 0.88rem;
            color: var(--text-muted);
            margin-top: 4px;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 12px 22px;
            background: var(--navy-primary);
            color: var(--white);
            text-decoration: none;
            font-weight: 700;
            font-size: 0.9rem;
            border-radius: var(--radius-md);
            transition: var(--transition);
            box-shadow: 0 6px 18px rgba(30, 58, 138, 0.25);
            border: none;
            cursor: pointer;
        }

        .btn-primary:hover {
            background: var(--navy-accent);
            transform: translateY(-2px);
            box-shadow: 0 10px 22px rgba(37, 99, 235, 0.35);
        }

        /* Filter Card dengan Border Navy Accent */
        .filter-card {
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 22px 26px;
            box-shadow: var(--shadow-sm);
            border: 1px solid #e2e8f0;
            margin-bottom: 24px;
            position: relative;
            overflow: hidden;
        }

        .filter-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--navy-primary);
        }

        .filter-form {
            display: flex;
            gap: 16px;
            align-items: flex-end;
            flex-wrap: wrap;
        }

        .filter-group {
            flex: 1;
            min-width: 210px;
        }

        .filter-group label {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--navy-dark);
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .form-control {
            width: 100%;
            padding: 11px 16px 11px 40px;
            border: 1.5px solid #cbd5e1;
            border-radius: var(--radius-md);
            font-family: inherit;
            font-size: 0.9rem;
            color: var(--navy-dark);
            background-color: var(--bg-body);
            outline: none;
            transition: var(--transition);
        }

        select.form-control {
            padding-left: 16px;
            cursor: pointer;
        }

        .form-control:focus {
            border-color: var(--navy-accent);
            background-color: var(--white);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
        }

        .btn-submit {
            padding: 11px 22px;
            background: var(--navy-primary);
            color: var(--white);
            font-weight: 700;
            border-radius: var(--radius-md);
            border: none;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
        }

        .btn-submit:hover {
            background: var(--navy-accent);
        }

        .btn-secondary {
            padding: 11px 20px;
            background: #f1f5f9;
            color: var(--navy-dark);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            border-radius: var(--radius-md);
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: 1px solid #cbd5e1;
        }

        .btn-secondary:hover {
            background: #e2e8f0;
            color: var(--navy-dark);
        }

        /* Table Card & Responsive */
        .table-card {
            background: var(--white);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            border: 1px solid #e2e8f0;
            overflow: hidden;
            margin-bottom: 24px;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        thead {
            background: #f1f5f9;
            border-bottom: 2px solid #e2e8f0;
        }

        th {
            padding: 16px 20px;
            font-size: 0.78rem;
            font-weight: 800;
            color: var(--navy-dark);
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }

        td {
            padding: 16px 20px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
            font-size: 0.9rem;
            color: var(--text-main);
        }

        tbody tr {
            transition: var(--transition);
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        tbody tr:hover {
            background: var(--navy-light);
        }

        /* Detail Komponen Tabel */
        .product-img {
            width: 58px;
            height: 58px;
            border-radius: var(--radius-md);
            object-fit: cover;
            border: 2px solid #e2e8f0;
            box-shadow: 0 2px 6px rgba(0,0,0,0.06);
        }

        .no-img {
            width: 58px;
            height: 58px;
            border-radius: var(--radius-md);
            background: #e2e8f0;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.72rem;
            font-weight: 700;
            border: 1px dashed #cbd5e1;
        }

        .badge-category {
            background: var(--navy-light);
            color: var(--navy-primary);
            padding: 5px 14px;
            border-radius: 30px;
            font-weight: 700;
            font-size: 0.8rem;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: 1px solid #bfdbfe;
        }

        .price-tag {
            color: var(--navy-dark);
            font-weight: 800;
            font-size: 0.95rem;
        }

        .stock-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-weight: 600;
            font-size: 0.88rem;
            padding: 4px 10px;
            border-radius: 8px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
        }

        /* Tombol Aksi */
        .action-btns {
            display: flex;
            gap: 8px;
        }

        .btn-sm {
            padding: 8px 14px;
            border-radius: var(--radius-sm);
            font-size: 0.82rem;
            font-weight: 700;
            text-decoration: none;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-warning {
            background: var(--amber-bg);
            color: var(--amber-accent);
            border: 1px solid #fde68a;
        }

        .btn-warning:hover {
            background: var(--amber-accent);
            color: var(--white);
            border-color: var(--amber-accent);
        }

        .btn-danger {
            background: var(--rose-bg);
            color: var(--rose-accent);
            border: 1px solid #fecdd3;
        }

        .btn-danger:hover {
            background: var(--rose-accent);
            color: var(--white);
            border-color: var(--rose-accent);
        }

        /* Pagination & Ringkasan Data */
        .pagination-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 24px;
        }

        .pagination-info {
            font-size: 0.88rem;
            color: var(--text-muted);
        }

        .pagination {
            display: flex;
            gap: 6px;
        }

        .pagination a {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 38px;
            height: 38px;
            padding: 0 10px;
            border-radius: var(--radius-md);
            background: var(--white);
            color: var(--navy-dark);
            text-decoration: none;
            font-weight: 700;
            font-size: 0.88rem;
            border: 1px solid #cbd5e1;
            transition: var(--transition);
        }

        .pagination a:hover {
            border-color: var(--navy-accent);
            color: var(--navy-accent);
            background: var(--navy-light);
        }

        .pagination a.active {
            background: var(--navy-primary);
            color: var(--white);
            border-color: var(--navy-primary);
            box-shadow: 0 4px 12px rgba(30, 58, 138, 0.25);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 50px 20px;
            color: var(--text-muted);
        }

        .empty-state i {
            font-size: 3rem;
            color: #cbd5e1;
            margin-bottom: 14px;
            display: block;
        }

        .empty-state h4 {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--navy-dark);
            margin-bottom: 4px;
        }

        /* Responsif Tablet & Mobile */
        @media (max-width: 992px) {
            .sidebar {
                width: 80px;
            }
            .sidebar-brand span, .sidebar-menu span, .admin-info {
                display: none;
            }
            .sidebar-brand {
                justify-content: center;
                padding: 20px 10px;
            }
            .sidebar-menu a {
                justify-content: center;
                padding: 14px;
            }
            .btn-logout {
                justify-content: center;
            }
            .main-wrapper {
                margin-left: 80px;
            }
            .top-header {
                padding: 16px 20px;
            }
            .content-body {
                padding: 24px 20px;
            }
        }
    </style>
</head>

<body>

    <!-- Sidebar Navigation (Navy Gradient Theme) -->
    <aside class="sidebar">
        <a href="index.php" class="sidebar-brand">
            <i class="fa-solid fa-cake-candles"></i>
            <span>BondoRoso</span>
        </a>

        <ul class="sidebar-menu">
            <li>
                <a href="index.php">
                    <i class="fa-solid fa-chart-pie"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="produk.php" class="active">
                    <i class="fa-solid fa-box-open"></i>
                    <span>Kelola Produk</span>
                </a>
            </li>
            <li>
                <a href="../index.php" target="_blank">
                    <i class="fa-solid fa-globe"></i>
                    <span>Lihat Website</span>
                </a>
            </li>
        </ul>

        <div class="sidebar-footer">
            <a href="logout.php" class="btn-logout">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span>Logout</span>
            </a>
        </div>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="main-wrapper">

        <!-- Header Navigasi Atas -->
        <header class="top-header">
            <div class="header-title-badge">
                <i class="fa-solid fa-layer-group" style="color: var(--navy-primary); font-size: 1.2rem;"></i>
                <h3>Manajemen Produk</h3>
            </div>
            <div class="admin-profile">
                <div class="avatar">
                    <?= strtoupper(substr($_SESSION['admin_nama'] ?? 'A', 0, 1)); ?>
                </div>
                <div class="admin-info">
                    <h4><?= htmlspecialchars($_SESSION['admin_nama'] ?? 'Administrator'); ?></h4>
                    <p>Admin Toko Kue</p>
                </div>
            </div>
        </header>

        <!-- Main Body Content -->
        <main class="content-body">

            <!-- Title & Quick Action -->
            <div class="page-header">
                <div class="page-title-group">
                    <h1>Daftar Produk</h1>
                    <p>Kelola seluruh katalog kue dan stok produk toko Anda.</p>
                </div>
                <a href="tambah.php" class="btn-primary">
                    <i class="fa-solid fa-plus"></i> Tambah Produk Baru
                </a>
            </div>

            <!-- Flash Message Notification -->
            <?php include "../includes/flash.php"; ?>

            <!-- Search & Filter Card -->
            <div class="filter-card">
                <form method="GET" class="filter-form">
                    <div class="filter-group">
                        <label for="keyword"><i class="fa-solid fa-magnifying-glass"></i> Cari Produk</label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-search"></i>
                            <input type="text" id="keyword" name="keyword" class="form-control" placeholder="Masukkan nama produk..." value="<?= htmlspecialchars($keyword); ?>">
                        </div>
                    </div>

                    <div class="filter-group">
                        <label for="kategori"><i class="fa-solid fa-tags"></i> Kategori</label>
                        <select name="kategori" id="kategori" class="form-control">
                            <option value="">Semua Kategori</option>
                            <option value="Cake" <?= $kategori == 'Cake' ? 'selected' : ''; ?>>Cake</option>
                            <option value="Brownies" <?= $kategori == 'Brownies' ? 'selected' : ''; ?>>Brownies</option>
                            <option value="Donat" <?= $kategori == 'Donat' ? 'selected' : ''; ?>>Donat</option>
                        </select>
                    </div>

                    <button type="submit" class="btn-submit">
                        <i class="fa-solid fa-filter"></i> Filter
                    </button>

                    <a href="produk.php" class="btn-secondary">
                        <i class="fa-solid fa-rotate-left"></i> Reset
                    </a>
                </form>
            </div>

            <!-- Table Products Card -->
            <div class="table-card">
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th width="60">No</th>
                                <th width="90">Gambar</th>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th width="160">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = $offset + 1;
                            if (mysqli_num_rows($query) > 0):
                                while ($row = mysqli_fetch_assoc($query)): 
                            ?>
                                <tr>
                                    <td><strong><?= $no++; ?></strong></td>
                                    <td>
                                        <?php if ($row['gambar']): ?>
                                            <img src="../uploads/produk/<?= htmlspecialchars($row['gambar']); ?>" alt="Foto Produk" class="product-img">
                                        <?php else: ?>
                                            <div class="no-img"><i class="fa-solid fa-image"></i></div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <strong style="color: var(--navy-dark); font-size: 0.95rem;"><?= htmlspecialchars($row['nama']); ?></strong>
                                    </td>
                                    <td>
                                        <span class="badge-category">
                                            <i class="fa-solid fa-tag" style="font-size: 0.7rem;"></i>
                                            <?= htmlspecialchars($row['kategori']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="price-tag">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></span>
                                    </td>
                                    <td>
                                        <span class="stock-badge">
                                            <i class="fa-solid fa-cubes" style="color: var(--navy-accent); font-size: 0.8rem;"></i>
                                            <?= $row['stok']; ?> unit
                                        </span>
                                    </td>
                                    <td>
                                        <div class="action-btns">
                                            <a href="edit.php?id=<?= $row['id']; ?>" class="btn-sm btn-warning" title="Edit Produk">
                                                <i class="fa-solid fa-pen-to-square"></i> Edit
                                            </a>
                                            <a href="hapus.php?id=<?= $row['id']; ?>" class="btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')" title="Hapus Produk">
                                                <i class="fa-solid fa-trash"></i> Hapus
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php 
                                endwhile; 
                            else: 
                            ?>
                                <tr>
                                    <td colspan="7">
                                        <div class="empty-state">
                                            <i class="fa-solid fa-box-open"></i>
                                            <h4>Tidak ada data produk</h4>
                                            <p>Data tidak ditemukan atau belum ada produk yang ditambahkan.</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination Container -->
            <div class="pagination-container">
                <div class="pagination-info">
                    Menampilkan total <strong><?= $total_data; ?></strong> produk (Halaman <strong><?= $page; ?></strong> dari <strong><?= max(1, $total_page); ?></strong>)
                </div>

                <?php if ($total_page > 1): ?>
                    <div class="pagination">
                        <?php for ($i = 1; $i <= $total_page; $i++): ?>
                            <a href="?page=<?= $i; ?>&keyword=<?= urlencode($keyword); ?>&kategori=<?= urlencode($kategori); ?>" class="<?= $page == $i ? 'active' : ''; ?>">
                                <?= $i; ?>
                            </a>
                        <?php endfor; ?>
                    </div>
                <?php endif; ?>
            </div>

        </main>

    </div>

</body>

</html>