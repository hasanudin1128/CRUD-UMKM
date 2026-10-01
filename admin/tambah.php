<?php

session_start();

require_once "../includes/auth.php";

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Produk - BondoRoso Admin</title>

    <!-- Google Fonts & Font Awesome -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            /* Navy Palette */
            --navy-dark: #0f172a;
            --navy-sidebar: #1e293b;
            --navy-card: #334155;
            --navy-primary: #1e40af;
            --navy-primary-hover: #1d4ed8;
            --navy-accent: #38bdf8;
            --accent-gold: #fbbf24;
            
            /* Text & Backgrounds */
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --text-light: #94a3b8;
            --bg-body: #f8fafc;
            --white: #ffffff;
            --border-color: #e2e8f0;

            /* Effects */
            --shadow-sm: 0 1px 3px rgba(15, 23, 42, 0.06);
            --shadow-md: 0 10px 25px -5px rgba(15, 23, 42, 0.08);
            --shadow-lg: 0 20px 30px -10px rgba(15, 23, 42, 0.12);
            --radius-sm: 10px;
            --radius-md: 16px;
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
            color: var(--text-dark);
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ==============================
           SIDEBAR (Deep Navy Styling)
        ============================== */
        .sidebar {
            width: 270px;
            background: var(--navy-sidebar);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            box-shadow: 4px 0 24px rgba(15, 23, 42, 0.15);
            transition: var(--transition);
        }

        .sidebar-brand {
            padding: 26px 24px;
            font-family: 'Playfair Display', serif;
            font-size: 1.45rem;
            font-weight: 700;
            color: var(--white);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .sidebar-brand i {
            color: var(--accent-gold);
            font-size: 1.6rem;
        }

        .sidebar-brand span {
            letter-spacing: -0.3px;
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
            gap: 14px;
            padding: 13px 18px;
            color: var(--text-light);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.92rem;
            border-radius: var(--radius-sm);
            transition: var(--transition);
        }

        .sidebar-menu a:hover {
            color: var(--white);
            background: rgba(255, 255, 255, 0.06);
            transform: translateX(4px);
        }

        .sidebar-menu a.active {
            background: var(--navy-primary);
            color: var(--white);
            box-shadow: 0 4px 14px rgba(30, 64, 175, 0.4);
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
            color: #f87171;
            background: rgba(239, 68, 68, 0.1);
            text-decoration: none;
            font-weight: 700;
            font-size: 0.88rem;
            border-radius: var(--radius-sm);
            transition: var(--transition);
        }

        .btn-logout:hover {
            background: #ef4444;
            color: var(--white);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        /* ==============================
           MAIN WRAPPER & HEADER
        ============================== */
        .main-wrapper {
            margin-left: 270px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .top-header {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            padding: 18px 40px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 90;
        }

        .top-header-title {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--navy-dark);
        }

        .top-header-title i {
            color: var(--navy-primary);
        }

        .admin-profile {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--navy-dark);
            color: var(--accent-gold);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 1rem;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.2);
        }

        .admin-info h4 {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--text-dark);
            line-height: 1.2;
        }

        .admin-info p {
            font-size: 0.78rem;
            color: var(--text-muted);
        }

        .content-body {
            padding: 36px 40px;
            flex-grow: 1;
        }

        /* ==============================
           PAGE HEADER & BREADCRUMB
        ============================== */
        .page-header {
            margin-bottom: 28px;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.82rem;
            color: var(--text-muted);
            margin-bottom: 8px;
            list-style: none;
        }

        .breadcrumb a {
            color: var(--text-muted);
            text-decoration: none;
            transition: var(--transition);
        }

        .breadcrumb a:hover {
            color: var(--navy-primary);
        }

        .page-header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.1rem;
            font-weight: 700;
            color: var(--navy-dark);
            letter-spacing: -0.5px;
        }

        .page-header p {
            margin-top: 4px;
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        /* ==============================
           FORM CARD & INPUTS
        ============================== */
        .form-card {
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 36px;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border-color);
            max-width: 920px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group.full {
            grid-column: 1 / -1;
        }

        .form-group label {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.84rem;
            font-weight: 700;
            color: var(--navy-dark);
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .required {
            color: #ef4444;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            color: var(--text-muted);
            font-size: 0.95rem;
            pointer-events: none;
            transition: var(--transition);
        }

        .form-control {
            width: 100%;
            padding: 13px 16px 13px 44px;
            border: 1.5px solid var(--border-color);
            border-radius: var(--radius-sm);
            font-family: inherit;
            font-size: 0.92rem;
            color: var(--text-dark);
            background-color: #f8fafc;
            outline: none;
            transition: var(--transition);
        }

        /* Input without icon fallback */
        .form-control.no-icon {
            padding-left: 16px;
        }

        .form-control:focus {
            border-color: var(--navy-primary);
            background-color: var(--white);
            box-shadow: 0 0 0 4px rgba(30, 64, 175, 0.1);
        }

        .form-control:focus + .input-icon,
        .input-wrapper:focus-within .input-icon {
            color: var(--navy-primary);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 120px;
            padding: 14px 16px;
            line-height: 1.5;
        }

        select.form-control {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%364748b'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
            background-size: 16px;
        }

        /* Currency Prefix */
        .price-input-group {
            display: flex;
            align-items: center;
        }

        .price-prefix {
            padding: 13px 16px;
            background: #e2e8f0;
            border: 1.5px solid var(--border-color);
            border-right: none;
            border-radius: var(--radius-sm) 0 0 var(--radius-sm);
            font-size: 0.88rem;
            font-weight: 700;
            color: var(--navy-dark);
        }

        .price-input-group .form-control {
            border-radius: 0 var(--radius-sm) var(--radius-sm) 0;
            padding-left: 16px;
        }

        /* ==============================
           CUSTOM DROPZONE / FILE UPLOAD
        ============================== */
        .dropzone-box {
            border: 2px dashed #cbd5e1;
            border-radius: var(--radius-md);
            padding: 24px;
            background: #f8fafc;
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
            position: relative;
        }

        .dropzone-box:hover {
            border-color: var(--navy-primary);
            background: rgba(30, 64, 175, 0.02);
        }

        .dropzone-icon {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: rgba(30, 64, 175, 0.08);
            color: var(--navy-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
            font-size: 1.2rem;
        }

        .dropzone-text h5 {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--navy-dark);
        }

        .dropzone-text p {
            font-size: 0.78rem;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .file-input-hidden {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        /* Image Preview Box */
        .preview-container {
            display: none;
            margin-top: 14px;
            align-items: center;
            gap: 14px;
            padding: 10px;
            background: #f1f5f9;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border-color);
        }

        .preview-img {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            object-fit: cover;
            border: 1px solid var(--border-color);
        }

        .preview-info {
            flex-grow: 1;
            overflow: hidden;
        }

        .preview-name {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--navy-dark);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .preview-size {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        /* ==============================
           BUTTONS & ACTIONS
        ============================== */
        .form-actions {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid var(--border-color);
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 14px 28px;
            background: var(--navy-primary);
            color: var(--white);
            text-decoration: none;
            font-weight: 700;
            font-size: 0.9rem;
            border-radius: var(--radius-sm);
            transition: var(--transition);
            box-shadow: 0 8px 18px rgba(30, 64, 175, 0.25);
            border: none;
            cursor: pointer;
        }

        .btn-primary:hover {
            background: var(--navy-primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 12px 22px rgba(30, 64, 175, 0.35);
        }

        .btn-secondary {
            padding: 14px 24px;
            background: #f1f5f9;
            color: var(--navy-dark);
            text-decoration: none;
            font-weight: 700;
            font-size: 0.9rem;
            border-radius: var(--radius-sm);
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: 1px solid var(--border-color);
        }

        .btn-secondary:hover {
            background: #e2e8f0;
            color: var(--navy-dark);
        }

        /* ==============================
           RESPONSIVE DESIGN
        ============================== */
        @media (max-width: 992px) {
            .sidebar {
                width: 80px;
            }

            .sidebar-brand span,
            .sidebar-menu span,
            .admin-info {
                display: none;
            }

            .sidebar-brand {
                justify-content: center;
                padding: 24px 0;
            }

            .sidebar-menu a {
                justify-content: center;
                padding: 14px;
            }

            .btn-logout {
                justify-content: center;
                padding: 12px;
            }

            .main-wrapper {
                margin-left: 80px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-group.full {
                grid-column: auto;
            }
        }

        @media (max-width: 600px) {
            .content-body {
                padding: 24px 20px;
            }

            .top-header {
                padding: 14px 20px;
            }

            .form-card {
                padding: 24px 20px;
            }

            .form-actions {
                flex-direction: column;
                align-items: stretch;
            }

            .btn-primary,
            .btn-secondary {
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <!-- ==============================
         SIDEBAR
    ============================== -->
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
                    <i class="fa-solid fa-box"></i>
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


    <!-- ==============================
         MAIN CONTENT AREA
    ============================== -->
    <div class="main-wrapper">

        <!-- TOP HEADER -->
        <header class="top-header">

            <div class="top-header-title">
                <i class="fa-solid fa-shield-halved"></i>
                <span>Panel Administrator</span>
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


        <!-- CONTENT BODY -->
        <main class="content-body">

            <!-- PAGE HEADER & BREADCRUMB -->
            <div class="page-header">

                <ul class="breadcrumb">
                    <li><a href="index.php">Dashboard</a></li>
                    <li><i class="fa-solid fa-chevron-right" style="font-size: 0.65rem;"></i></li>
                    <li><a href="produk.php">Produk</a></li>
                    <li><i class="fa-solid fa-chevron-right" style="font-size: 0.65rem;"></i></li>
                    <li style="color: var(--navy-primary); font-weight: 600;">Tambah Produk</li>
                </ul>

                <h1>Tambah Produk Baru</h1>
                <p>Isi formulir berikut untuk menambahkan item kue baru ke katalog BondoRoso.</p>

            </div>


            <!-- FORM CARD -->
            <div class="form-card">

                <form action="proses_produk.php" method="POST" enctype="multipart/form-data">

                    <input type="hidden" name="aksi" value="tambah">

                    <div class="form-grid">

                        <!-- NAMA PRODUK -->
                        <div class="form-group full">
                            <label for="nama">
                                Nama Produk <span class="required">*</span>
                            </label>
                            <div class="input-wrapper">
                                <i class="fa-solid fa-cake-candles input-icon"></i>
                                <input type="text" id="nama" name="nama" class="form-control" placeholder="Contoh: Red Velvet Special Layer" required>
                            </div>
                        </div>


                        <!-- KATEGORI -->
                        <div class="form-group">
                            <label for="kategori">
                                Kategori <span class="required">*</span>
                            </label>
                            <div class="input-wrapper">
                                <i class="fa-solid fa-layer-group input-icon"></i>
                                <select name="kategori" id="kategori" class="form-control" required>
                                    <option value="" disabled selected>Pilih kategori...</option>
                                    <option value="Cake">Cake</option>
                                    <option value="Brownies">Brownies</option>
                                    <option value="Donat">Donat</option>
                                </select>
                            </div>
                        </div>


                        <!-- HARGA -->
                        <div class="form-group">
                            <label for="harga">
                                Harga <span class="required">*</span>
                            </label>
                            <div class="price-input-group">
                                <span class="price-prefix">Rp</span>
                                <input type="number" id="harga" name="harga" class="form-control" min="0" placeholder="50000" required>
                            </div>
                        </div>


                        <!-- STOK -->
                        <div class="form-group">
                            <label for="stok">
                                Jumlah Stok <span class="required">*</span>
                            </label>
                            <div class="input-wrapper">
                                <i class="fa-solid fa-cubes input-icon"></i>
                                <input type="number" id="stok" name="stok" class="form-control" min="0" placeholder="25" required>
                            </div>
                        </div>


                        <!-- GAMBAR PRODUK (Dropzone & Live Preview) -->
                        <div class="form-group">
                            <label for="gambar">Gambar Produk</label>

                            <div class="dropzone-box">
                                <div class="dropzone-icon">
                                    <i class="fa-solid fa-cloud-arrow-up"></i>
                                </div>
                                <div class="dropzone-text">
                                    <h5>Pilih atau Tarik Foto Produk</h5>
                                    <p>Format: JPG, JPEG, PNG, WEBP (Max 2MB)</p>
                                </div>
                                <input type="file" id="gambar" name="gambar" class="file-input-hidden" accept=".jpg,.jpeg,.png,.webp" onchange="previewImage(event)">
                            </div>

                            <!-- Visual Preview Bar -->
                            <div class="preview-container" id="previewContainer">
                                <img src="" alt="Preview" class="preview-img" id="previewImg">
                                <div class="preview-info">
                                    <div class="preview-name" id="previewName">filename.jpg</div>
                                    <div class="preview-size" id="previewSize">0 KB</div>
                                </div>
                            </div>
                        </div>


                        <!-- DESKRIPSI -->
                        <div class="form-group full">
                            <label for="deskripsi">
                                Deskripsi Produk <span class="required">*</span>
                            </label>
                            <textarea id="deskripsi" name="deskripsi" class="form-control no-icon" rows="5" placeholder="Tulis deskripsi rinci mengenai rasa, bahan, dan ukuran produk..." required></textarea>
                        </div>

                    </div>


                    <!-- ACTION BUTTONS -->
                    <div class="form-actions">

                        <button type="submit" class="btn-primary">
                            <i class="fa-solid fa-floppy-disk"></i>
                            <span>Simpan Produk</span>
                        </button>

                        <a href="produk.php" class="btn-secondary">
                            <i class="fa-solid fa-arrow-left"></i>
                            <span>Kembali</span>
                        </a>

                    </div>

                </form>

            </div>

        </main>

    </div>

    <!-- JAVASCRIPT: Live Image Preview -->
    <script>
        function previewImage(event) {
            const input = event.target;
            const previewContainer = document.getElementById('previewContainer');
            const previewImg = document.getElementById('previewImg');
            const previewName = document.getElementById('previewName');
            const previewSize = document.getElementById('previewSize');

            if (input.files && input.files[0]) {
                const file = input.files[0];
                const reader = new FileReader();

                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewName.textContent = file.name;
                    previewSize.textContent = (file.size / 1024).toFixed(1) + ' KB';
                    previewContainer.style.display = 'flex';
                }

                reader.readAsDataURL(file);
            } else {
                previewContainer.style.display = 'none';
            }
        }
    </script>

</body>

</html>