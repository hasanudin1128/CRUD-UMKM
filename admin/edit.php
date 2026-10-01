<?php
session_start();

require_once __DIR__ . "/../includes/auth.php";
require_once __DIR__ . "/../config/database.php";

// 1. Ambil & Validasi ID Produk
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    $_SESSION['error'] = "ID produk tidak valid!";
    header("Location: produk.php");
    exit;
}

// 2. Ambil Data Produk Eksisting dari Database
$id_safe = mysqli_real_escape_string($conn, $id);
$query = mysqli_query($conn, "SELECT * FROM produk WHERE id = '$id_safe'");

if (!$query || mysqli_num_rows($query) === 0) {
    $_SESSION['error'] = "Data produk tidak ditemukan!";
    header("Location: produk.php");
    exit;
}

$produk = mysqli_fetch_assoc($query);

// 3. Proses Update Data Produk saat Form Disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama      = trim($_POST['nama'] ?? '');
    $kategori  = trim($_POST['kategori'] ?? '');
    $harga     = (int)($_POST['harga'] ?? 0);
    $stok      = (int)($_POST['stok'] ?? 0);
    $deskripsi = trim($_POST['deskripsi'] ?? '');

    // Validasi Form Sederhana
    if (empty($nama) || empty($kategori) || $harga < 0 || $stok < 0) {
        $_SESSION['error'] = "Mohon isi semua data produk dengan benar!";
    } else {
        $nama_safe      = mysqli_real_escape_string($conn, $nama);
        $kategori_safe  = mysqli_real_escape_string($conn, $kategori);
        $harga_safe     = (int)$harga;
        $stok_safe      = (int)$stok;
        $deskripsi_safe = mysqli_real_escape_string($conn, $deskripsi);

        $gambar_nama = $produk['gambar']; // Default: pertahankan gambar lama

        // Cek Upload Gambar Baru
        if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
            $file_tmp   = $_FILES['gambar']['tmp_name'];
            $file_name  = $_FILES['gambar']['name'];
            $file_ext   = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            $allowed    = ['jpg', 'jpeg', 'png', 'webp', 'gif'];

            if (in_array($file_ext, $allowed)) {
                $new_filename = time() . '_' . uniqid() . '.' . $file_ext;
                $upload_dir   = __DIR__ . "/../uploads/produk/";

                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }

                if (move_uploaded_file($file_tmp, $upload_dir . $new_filename)) {
                    // Hapus gambar lama jika ada dan file-nya ada di direktori
                    if ($produk['gambar'] && file_exists($upload_dir . $produk['gambar'])) {
                        @unlink($upload_dir . $produk['gambar']);
                    }
                    $gambar_nama = $new_filename;
                } else {
                    $_SESSION['error'] = "Gagal mengunggah gambar baru!";
                }
            } else {
                $_SESSION['error'] = "Format gambar tidak didukung! (Gunakan JPG, PNG, WEBP)";
            }
        }

        // Eksekusi Query Update jika Tidak Ada Error
        if (!isset($_SESSION['error'])) {
            // Cek apakah kolom deskripsi ada di tabel
            $update_sql = "UPDATE produk SET 
                nama = '$nama_safe',
                kategori = '$kategori_safe',
                harga = '$harga_safe',
                stok = '$stok_safe',
                deskripsi = '$deskripsi_safe',
                gambar = '$gambar_nama'
                WHERE id = '$id_safe'";

            if (mysqli_query($conn, $update_sql)) {
                $_SESSION['success'] = "Produk berhasil diperbarui!";
                header("Location: produk.php");
                exit;
            } else {
                $_SESSION['error'] = "Gagal memperbarui produk: " . mysqli_error($conn);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk - BondoRoso Admin</title>

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
            --emerald-accent: #059669;
            --emerald-bg: #ecfdf5;
            
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

        /* Header Halaman & Navigation */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
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

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            background: var(--white);
            color: var(--navy-dark);
            border: 1px solid var(--navy-border);
            text-decoration: none;
            font-weight: 700;
            font-size: 0.88rem;
            border-radius: var(--radius-md);
            transition: var(--transition);
            box-shadow: var(--shadow-sm);
        }

        .btn-back:hover {
            background: var(--navy-light);
            color: var(--navy-accent);
            border-color: var(--navy-accent);
            transform: translateX(-3px);
        }

        /* Form Card Container */
        .form-card {
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 32px;
            box-shadow: var(--shadow-sm);
            border: 1px solid #e2e8f0;
            position: relative;
            overflow: hidden;
        }

        .form-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
            background: linear-gradient(180deg, var(--navy-primary) 0%, var(--navy-accent) 100%);
        }

        .form-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 32px;
        }

        .form-section-title {
            font-size: 1.05rem;
            font-weight: 800;
            color: var(--navy-dark);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px dashed #e2e8f0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-section-title i {
            color: var(--navy-accent);
        }

        /* Form Controls */
        .form-group {
            margin-bottom: 22px;
        }

        .form-group label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.82rem;
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
            font-size: 0.95rem;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px 12px 42px;
            border: 1.5px solid #cbd5e1;
            border-radius: var(--radius-md);
            font-family: inherit;
            font-size: 0.92rem;
            color: var(--navy-dark);
            background-color: var(--bg-body);
            outline: none;
            transition: var(--transition);
        }

        select.form-control {
            padding-left: 16px;
            cursor: pointer;
        }

        textarea.form-control {
            padding: 12px 16px;
            min-height: 110px;
            resize: vertical;
        }

        .form-control:focus {
            border-color: var(--navy-accent);
            background-color: var(--white);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        /* Image Upload Box & Preview */
        .image-preview-card {
            background: var(--bg-body);
            border: 2px dashed #cbd5e1;
            border-radius: var(--radius-md);
            padding: 20px;
            text-align: center;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .image-preview-card:hover {
            border-color: var(--navy-accent);
            background: var(--navy-light);
        }

        .preview-box {
            width: 100%;
            height: 200px;
            border-radius: var(--radius-sm);
            overflow: hidden;
            background: #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
            border: 1px solid #cbd5e1;
            position: relative;
        }

        .preview-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }

        .no-preview {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            color: var(--text-muted);
        }

        .no-preview i {
            font-size: 2.5rem;
            color: #94a3b8;
        }

        .file-upload-btn {
            display: inline-block;
            width: 100%;
            padding: 11px;
            background: var(--navy-primary);
            color: var(--white);
            font-weight: 700;
            font-size: 0.88rem;
            border-radius: var(--radius-md);
            cursor: pointer;
            transition: var(--transition);
            text-align: center;
            box-shadow: 0 4px 12px rgba(30, 58, 138, 0.2);
        }

        .file-upload-btn:hover {
            background: var(--navy-accent);
            transform: translateY(-2px);
        }

        .file-upload-btn input[type="file"] {
            display: none;
        }

        .upload-info {
            font-size: 0.78rem;
            color: var(--text-muted);
            margin-top: 10px;
            line-height: 1.4;
        }

        /* Action Buttons Area */
        .form-actions {
            margin-top: 32px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: 12px;
            justify-content: flex-end;
        }

        .btn-submit {
            padding: 12px 28px;
            background: var(--navy-primary);
            color: var(--white);
            font-weight: 700;
            font-size: 0.92rem;
            border-radius: var(--radius-md);
            border: none;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 6px 18px rgba(30, 58, 138, 0.25);
        }

        .btn-submit:hover {
            background: var(--navy-accent);
            transform: translateY(-2px);
            box-shadow: 0 10px 22px rgba(37, 99, 235, 0.35);
        }

        .btn-cancel {
            padding: 12px 22px;
            background: #f1f5f9;
            color: var(--navy-dark);
            text-decoration: none;
            font-weight: 700;
            font-size: 0.92rem;
            border-radius: var(--radius-md);
            transition: var(--transition);
            border: 1px solid #cbd5e1;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-cancel:hover {
            background: #e2e8f0;
            color: var(--navy-dark);
        }

        /* Status Badge Info Card */
        .info-card {
            background: var(--navy-light);
            border: 1px solid #bfdbfe;
            border-radius: var(--radius-md);
            padding: 16px;
            margin-top: 20px;
        }

        .info-card h5 {
            font-size: 0.85rem;
            font-weight: 800;
            color: var(--navy-primary);
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .info-card p {
            font-size: 0.78rem;
            color: #334155;
            line-height: 1.5;
        }

        /* Responsive Breakpoints */
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
            .form-grid {
                grid-template-columns: 1fr;
            }
            .form-row {
                grid-template-columns: 1fr;
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
                <i class="fa-solid fa-pen-to-square" style="color: var(--navy-primary); font-size: 1.2rem;"></i>
                <h3>Edit Informasi Produk</h3>
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
                    <h1>Edit Produk</h1>
                    <p>Perbarui informasi detail, harga, stok, atau gambar produk kue Anda.</p>
                </div>
                <a href="produk.php" class="btn-back">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar
                </a>
            </div>

            <!-- Flash Message Notification -->
            <?php include "../includes/flash.php"; ?>

            <!-- Form Edit Produk -->
            <div class="form-card">
                <form action="" method="POST" enctype="multipart/form-data">
                    
                    <div class="form-grid">
                        
                        <!-- Kolom Kiri: Informasi Utama -->
                        <div class="form-main-col">
                            <div class="form-section-title">
                                <i class="fa-solid fa-circle-info"></i> Detail Produk
                            </div>

                            <div class="form-group">
                                <label for="nama"><i class="fa-solid fa-heading"></i> Nama Produk</label>
                                <div class="input-wrapper">
                                    <i class="fa-solid fa-cake-candles"></i>
                                    <input type="text" id="nama" name="nama" class="form-control" placeholder="Contoh: Red Velvet Cake Premium" value="<?= htmlspecialchars($produk['nama']); ?>" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="kategori"><i class="fa-solid fa-tags"></i> Kategori Produk</label>
                                <select name="kategori" id="kategori" class="form-control" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <option value="Cake" <?= ($produk['kategori'] == 'Cake') ? 'selected' : ''; ?>>Cake</option>
                                    <option value="Brownies" <?= ($produk['kategori'] == 'Brownies') ? 'selected' : ''; ?>>Brownies</option>
                                    <option value="Donat" <?= ($produk['kategori'] == 'Donat') ? 'selected' : ''; ?>>Donat</option>
                                </select>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="harga"><i class="fa-solid fa-money-bill-wave"></i> Harga (Rp)</label>
                                    <div class="input-wrapper">
                                        <i class="fa-solid fa-tag"></i>
                                        <input type="number" id="harga" name="harga" class="form-control" placeholder="0" min="0" value="<?= $produk['harga']; ?>" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="stok"><i class="fa-solid fa-cubes"></i> Stok Produk</label>
                                    <div class="input-wrapper">
                                        <i class="fa-solid fa-boxes-stacked"></i>
                                        <input type="number" id="stok" name="stok" class="form-control" placeholder="0" min="0" value="<?= $produk['stok']; ?>" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group" style="margin-bottom: 0;">
                                <label for="deskripsi"><i class="fa-solid fa-align-left"></i> Deskripsi Produk (Opsional)</label>
                                <textarea id="deskripsi" name="deskripsi" class="form-control" placeholder="Tuliskan varian rasa, ukuran, atau deskripsi menarik tentang produk ini..."><?= htmlspecialchars($produk['deskripsi'] ?? ''); ?></textarea>
                            </div>
                        </div>

                        <!-- Kolom Kanan: Upload & Preview Gambar -->
                        <div class="form-side-col">
                            <div class="form-section-title">
                                <i class="fa-solid fa-image"></i> Foto Produk
                            </div>

                            <div class="image-preview-card">
                                <div class="preview-box" id="previewBox">
                                    <?php if ($produk['gambar'] && file_exists(__DIR__ . "/../uploads/produk/" . $produk['gambar'])): ?>
                                        <img src="../uploads/produk/<?= htmlspecialchars($produk['gambar']); ?>" id="imgPreview" alt="Foto Produk">
                                    <?php else: ?>
                                        <div class="no-preview" id="noPreview">
                                            <i class="fa-solid fa-image"></i>
                                            <span>Belum Ada Gambar</span>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <label class="file-upload-btn">
                                    <i class="fa-solid fa-cloud-arrow-up"></i> Ganti Gambar Baru
                                    <input type="file" name="gambar" id="gambarInput" accept="image/png, image/jpeg, image/jpg, image/webp" onchange="previewImage(event)">
                                </label>

                                <div class="upload-info">
                                    Format: <strong>JPG, PNG, WEBP</strong><br>
                                    Ukuran rekomendasi: <strong>1:1 (Square) / Max 2MB</strong>
                                </div>
                            </div>

                            <div class="info-card">
                                <h5><i class="fa-solid fa-lightbulb"></i> Tips Pengelolaan</h5>
                                <p>Biarkan tombol gambar kosong jika Anda tidak ingin mengganti foto produk yang sudah ada.</p>
                            </div>
                        </div>

                    </div>

                    <!-- Tombol Aksi -->
                    <div class="form-actions">
                        <a href="produk.php" class="btn-cancel">
                            <i class="fa-solid fa-xmark"></i> Batal
                        </a>
                        <button type="submit" class="btn-submit">
                            <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                        </button>
                    </div>

                </form>
            </div>

        </main>

    </div>

    <!-- Script Live Image Preview -->
    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            const previewBox = document.getElementById('previewBox');
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewBox.innerHTML = `<img src="${e.target.result}" alt="Preview Foto Produk">`;
                }
                reader.readAsDataURL(file);
            }
        }
    </script>

</body>

</html>