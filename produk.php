<?php

// Menggunakan __DIR__ agar path absolut dan konsisten
require_once __DIR__ . '/config/database.php';

// Verifikasi koneksi database
if (!isset($conn) || !$conn) {
    die("Koneksi database gagal. Periksa konfigurasi Anda.");
}

$keyword = trim($_GET['keyword'] ?? '');

// Penggunaan Prepared Statement untuk keamanan SQL Injection
if ($keyword !== '') {
    $search_param = "%" . $keyword . "%";
    $stmt = mysqli_prepare($conn, "SELECT * FROM produk WHERE nama LIKE ? OR deskripsi LIKE ? ORDER BY id DESC");
    mysqli_stmt_bind_param($stmt, "ss", $search_param, $search_param);
    mysqli_stmt_execute($stmt);
    $query = mysqli_stmt_get_result($stmt);
} else {
    $query = mysqli_query($conn, "SELECT * FROM produk ORDER BY id DESC");
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Produk - BondoRoso</title>

    <!-- Google Fonts & Font Awesome Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,500;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            /* Palette Warna Deep Navy & Luxury Gold */
            --navy-dark: #0b1329;
            --navy-primary: #111c3a;
            --navy-medium: #1e2942;
            --navy-light: #2c3e66;
            --navy-accent: #3b82f6;
            
            --gold: #d97706;
            --gold-hover: #b45309;
            --gold-light: #fef3c7;
            
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --text-light: #f8fafc;
            
            --bg-body: #f1f5f9;
            --card-bg: #ffffff;
            
            --shadow-sm: 0 4px 6px -1px rgba(11, 19, 41, 0.05);
            --shadow-md: 0 10px 15px -3px rgba(11, 19, 41, 0.08);
            --shadow-lg: 0 20px 25px -5px rgba(11, 19, 41, 0.12);
            
            --radius-sm: 10px;
            --radius-md: 18px;
            --radius-lg: 28px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
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
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .container {
            max-width: 1240px;
            margin: 0 auto;
            padding: 0 24px;
            width: 100%;
        }

        /* Navbar Modern Navy */
        .navbar {
            background: rgba(11, 19, 41, 0.95);
            backdrop-filter: blur(16px);
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            padding: 18px 0;
        }

        .navbar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.85rem;
            font-weight: 700;
            color: var(--text-light);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            letter-spacing: 0.5px;
        }

        .brand i {
            color: var(--gold);
            font-size: 1.6rem;
            filter: drop-shadow(0 2px 4px rgba(217, 119, 6, 0.4));
        }

        .nav-links {
            display: flex;
            gap: 36px;
            list-style: none;
        }

        .nav-links a {
            text-decoration: none;
            color: rgba(248, 250, 252, 0.8);
            font-weight: 600;
            font-size: 0.95rem;
            transition: var(--transition);
            position: relative;
            padding: 4px 0;
        }

        .nav-links a:hover,
        .nav-links a.active {
            color: var(--gold);
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0%;
            height: 2px;
            background: var(--gold);
            transition: var(--transition);
            border-radius: 2px;
        }

        .nav-links a:hover::after,
        .nav-links a.active::after {
            width: 100%;
        }

        /* Hero / Page Header Section */
        .page-header {
            background: linear-gradient(135deg, var(--navy-dark) 0%, var(--navy-primary) 50%, var(--navy-medium) 100%);
            padding: 70px 0 90px 0;
            border-radius: 0 0 40px 40px;
            text-align: center;
            color: var(--text-light);
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(11, 19, 41, 0.25);
        }

        /* Ambient Glow Effect */
        .page-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: 50%;
            transform: translateX(-50%);
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(217, 119, 6, 0.15) 0%, rgba(11, 19, 41, 0) 70%);
            pointer-events: none;
        }

        .page-header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 12px;
            letter-spacing: -0.5px;
            background: linear-gradient(180deg, #ffffff 0%, #cbd5e1 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .page-header p {
            color: rgba(248, 250, 252, 0.75);
            font-size: 1.1rem;
            max-width: 580px;
            margin: 0 auto;
            font-weight: 400;
        }

        /* Form Pencarian Melayang (Floating) */
        .search-box {
            background: var(--card-bg);
            padding: 10px;
            border-radius: 60px;
            box-shadow: 0 20px 40px -10px rgba(11, 19, 41, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.8);
            max-width: 650px;
            margin: -40px auto 40px auto;
            position: relative;
            z-index: 20;
            transition: var(--transition);
        }

        .search-box:focus-within {
            box-shadow: 0 20px 40px -5px rgba(11, 19, 41, 0.22);
            transform: translateY(-2px);
        }

        .search-form {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .search-input-wrapper {
            display: flex;
            align-items: center;
            flex-grow: 1;
            padding-left: 20px;
            gap: 14px;
            color: var(--text-muted);
        }

        .search-input-wrapper i {
            font-size: 1.1rem;
            color: var(--navy-medium);
        }

        .search-input-wrapper input {
            width: 100%;
            border: none;
            outline: none;
            font-family: inherit;
            font-size: 1rem;
            color: var(--text-dark);
            background: transparent;
            font-weight: 500;
        }

        .search-input-wrapper input::placeholder {
            color: #94a3b8;
        }

        .btn-search {
            background: linear-gradient(135deg, var(--navy-primary) 0%, var(--navy-medium) 100%);
            color: var(--text-light);
            border: none;
            padding: 14px 32px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.95rem;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 4px 12px rgba(17, 28, 58, 0.25);
        }

        .btn-search:hover {
            background: linear-gradient(135deg, var(--navy-medium) 0%, var(--navy-light) 100%);
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(17, 28, 58, 0.35);
        }

        /* Status Hasil Pencarian */
        .search-status {
            background: var(--card-bg);
            border-radius: var(--radius-sm);
            padding: 14px 20px;
            margin-bottom: 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: var(--shadow-sm);
        }

        .search-status p {
            font-size: 0.95rem;
            color: var(--text-muted);
        }

        .search-status strong {
            color: var(--navy-primary);
        }

        .btn-reset {
            color: var(--gold-hover);
            text-decoration: none;
            font-weight: 700;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 6px;
            background: var(--gold-light);
            transition: var(--transition);
        }

        .btn-reset:hover {
            background: #fde68a;
            color: #92400e;
        }

        /* Grid & Card Produk */
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 32px;
            margin-bottom: 80px;
        }

        .card {
            background: var(--card-bg);
            border-radius: var(--radius-md);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            border: 1px solid rgba(226, 232, 240, 0.8);
            transition: var(--transition);
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-lg);
            border-color: rgba(203, 213, 225, 0.8);
        }

        .card-image-wrapper {
            position: relative;
            width: 100%;
            padding-top: 75%; /* Ratio 4:3 */
            overflow: hidden;
            background: #e2e8f0;
        }

        .product-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .card:hover .product-image {
            transform: scale(1.08);
        }

        .badge-kategori {
            position: absolute;
            top: 16px;
            left: 16px;
            background: rgba(11, 19, 41, 0.85);
            backdrop-filter: blur(10px);
            color: var(--gold);
            padding: 6px 14px;
            border-radius: 30px;
            font-size: 0.75rem;
            font-weight: 800;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(217, 119, 6, 0.3);
        }

        .card-body {
            padding: 24px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .card-body h3 {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 10px;
            color: var(--navy-primary);
            line-height: 1.35;
        }

        .card-body .deskripsi {
            color: var(--text-muted);
            font-size: 0.9rem;
            margin-bottom: 20px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            line-height: 1.6;
        }

        .card-price-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto;
            padding-top: 18px;
            border-top: 1px dashed #e2e8f0;
        }

        .price-container {
            display: flex;
            flex-direction: column;
        }

        .price-label {
            font-size: 0.75rem;
            color: var(--text-muted);
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .price-tag {
            font-size: 1.35rem;
            font-weight: 800;
            color: var(--navy-primary);
        }

        .btn-detail {
            padding: 10px 20px;
            border-radius: var(--radius-sm);
            background: var(--navy-primary);
            color: var(--text-light);
            text-decoration: none;
            font-weight: 700;
            font-size: 0.85rem;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 10px rgba(17, 28, 58, 0.15);
        }

        .btn-detail:hover {
            background: var(--gold);
            color: var(--navy-dark);
            box-shadow: 0 6px 14px rgba(217, 119, 6, 0.3);
            transform: translateY(-2px);
        }

        /* Empty State */
        .empty-state {
            grid-column: 1 / -1;
            text-align: center;
            padding: 80px 20px;
            background: var(--card-bg);
            border-radius: var(--radius-md);
            color: var(--text-muted);
            box-shadow: var(--shadow-sm);
            border: 1px dashed #cbd5e1;
        }

        .empty-icon {
            width: 80px;
            height: 80px;
            background: var(--bg-body);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px auto;
            color: var(--navy-medium);
            font-size: 2rem;
        }

        .empty-state h3 {
            font-size: 1.4rem;
            color: var(--navy-primary);
            font-weight: 700;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .page-header h1 { font-size: 2.25rem; }
            .grid { grid-template-columns: 1fr; }
            .search-box { margin-left: 16px; margin-right: 16px; }
            .nav-links { gap: 20px; }
        }
    </style>
</head>

<body>

    <!-- Navbar Modern Navy -->
    <nav class="navbar">
        <div class="container">
            <a href="index.php" class="brand">
                <i class="fa-solid fa-cake-candles"></i> BondoRoso
            </a>
            <ul class="nav-links">
                <li><a href="index.php">Beranda</a></li>
                <li><a href="produk.php" class="active">Produk</a></li>
                <li><a href="tentang.php">Tentang Kami</a></li>
            </ul>
        </div>
    </nav>

    <!-- Header Halaman Hero Navy -->
    <section class="page-header">
        <div class="container">
            <h1>Katalog Produk Eksklusif</h1>
            <p>Jelajahi aneka kue lezat buatan khusus dengan bahan pilihan premium untuk setiap momen berharga Anda.</p>
        </div>
    </section>

    <main class="container">
        <!-- Form Pencarian Interaktif -->
        <div class="search-box">
            <form method="GET" class="search-form">
                <div class="search-input-wrapper">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" name="keyword" placeholder="Cari kue favorit Anda berdasarkan nama atau rasanya..." value="<?= htmlspecialchars($keyword); ?>">
                </div>
                <button type="submit" class="btn-search">
                    <span>Cari</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
            </form>
        </div>

        <!-- Notifikasi Keterangan Pencarian -->
        <?php if (!empty($keyword)): ?>
            <div class="search-status">
                <p>Menampilkan hasil pencarian untuk kata kunci: <strong>"<?= htmlspecialchars($keyword); ?>"</strong></p>
                <a href="produk.php" class="btn-reset">
                    <i class="fa-solid fa-rotate-left"></i> Reset Pencarian
                </a>
            </div>
        <?php endif; ?>

        <!-- Grid Produk -->
        <div class="grid">
            <?php if ($query && mysqli_num_rows($query) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($query)): ?>
                    <div class="card">
                        <div class="card-image-wrapper">
                            <?php if (!empty($row['kategori'])): ?>
                                <span class="badge-kategori">
                                    <?= htmlspecialchars($row['kategori']); ?>
                                </span>
                            <?php endif; ?>

                            <?php if (!empty($row['gambar'])): ?>
                                <img src="uploads/produk/<?= htmlspecialchars($row['gambar']); ?>" alt="<?= htmlspecialchars($row['nama']); ?>" class="product-image">
                            <?php else: ?>
                                <img src="https://images.unsplash.com/photo-1578985545062-69928b1d9587?auto=format&fit=crop&w=600&q=80" alt="Default Product" class="product-image">
                            <?php endif; ?>
                        </div>

                        <div class="card-body">
                            <h3><?= htmlspecialchars($row['nama']); ?></h3>

                            <?php if (!empty($row['deskripsi'])): ?>
                                <p class="deskripsi"><?= htmlspecialchars($row['deskripsi']); ?></p>
                            <?php endif; ?>

                            <div class="card-price-row">
                                <div class="price-container">
                                    <span class="price-label">Harga</span>
                                    <div class="price-tag">
                                        Rp <?= number_format($row['harga'], 0, ',', '.'); ?>
                                    </div>
                                </div>
                                <a href="detail.php?id=<?= $row['id']; ?>" class="btn-detail">
                                    <span>Detail</span>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <h3>Produk tidak ditemukan</h3>
                    <p style="margin-top: 8px;">Kata kunci yang Anda cari tidak cocok dengan produk apa pun.</p>
                    <?php if (!empty($keyword)): ?>
                        <a href="produk.php" class="btn-search" style="display: inline-flex; margin-top: 24px; text-decoration: none;">
                            Tampilkan Semua Produk
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>

</body>

</html>