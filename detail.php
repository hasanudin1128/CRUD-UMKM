<?php

require_once __DIR__ . "/config/database.php";

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$query = mysqli_query($conn, "SELECT * FROM produk WHERE id = $id");
$produk = mysqli_fetch_assoc($query);

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $produk ? htmlspecialchars($produk['nama']) . ' - BondoRoso ' : 'Produk Tidak Ditemukan - BondoRoso '; ?></title>

    <!-- Google Fonts & FontAwesome Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            /* Navy Blue Palette */
            --primary: #0a2540;
            --primary-hover: #061729;
            --primary-soft: #e8eef5;
            --secondary: #d97706; /* Warm Gold accent */
            --secondary-hover: #b45309;
            --accent: #f0f4f9;
            --dark: #07111e;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --bg-light: #f8fafc;
            --white: #ffffff;
            --border-light: #e2e8f0;
            --shadow-sm: 0 4px 12px rgba(10, 37, 64, 0.04);
            --shadow-md: 0 10px 25px -5px rgba(10, 37, 64, 0.08);
            --shadow-lg: 0 20px 35px -10px rgba(10, 37, 64, 0.18);
            --radius-sm: 12px;
            --radius-md: 20px;
            --radius-lg: 32px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-light);
            color: var(--text-dark);
            line-height: 1.6;
            overflow-x: hidden;
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

        /* Navbar */
        .navbar {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid rgba(10, 37, 64, 0.06);
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
            color: var(--primary);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .brand i {
            background: var(--primary-soft);
            color: var(--primary);
            padding: 10px;
            border-radius: 12px;
            font-size: 1.2rem;
        }

        .nav-links {
            display: flex;
            gap: 36px;
            list-style: none;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--text-dark);
            font-weight: 600;
            font-size: 0.95rem;
            transition: var(--transition);
        }

        .nav-links a:hover,
        .nav-links a.active {
            color: var(--primary);
        }

        /* Breadcrumb */
        .breadcrumb {
            padding: 24px 0;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.9rem;
            color: var(--text-muted);
        }

        .breadcrumb a {
            color: var(--text-muted);
            text-decoration: none;
            transition: var(--transition);
        }

        .breadcrumb a:hover {
            color: var(--primary);
        }

        .breadcrumb i {
            font-size: 0.75rem;
            color: #cbd5e1;
        }

        .breadcrumb span {
            color: var(--primary);
            font-weight: 600;
        }

        /* Main Section */
        .detail-wrapper {
            padding-bottom: 80px;
            flex-grow: 1;
        }

        .product-card-detail {
            background: var(--white);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border-light);
            padding: 40px;
            display: grid;
            grid-template-columns: 1fr 1.1fr;
            gap: 48px;
            align-items: start;
        }

        /* Image Column */
        .product-media {
            position: relative;
            border-radius: var(--radius-md);
            overflow: hidden;
            background: #f1f5f9;
            box-shadow: var(--shadow-sm);
        }

        .product-image {
            width: 100%;
            height: 480px;
            object-fit: cover;
            display: block;
            transition: transform 0.5s ease;
        }

        .product-media:hover .product-image {
            transform: scale(1.04);
        }

        .category-badge {
            position: absolute;
            top: 20px;
            left: 20px;
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(8px);
            color: var(--primary);
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 800;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            box-shadow: var(--shadow-sm);
        }

        /* Content Column */
        .product-info {
            display: flex;
            flex-direction: column;
        }

        .product-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            color: var(--dark);
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 16px;
        }

        .price-container {
            display: flex;
            align-items: baseline;
            gap: 12px;
            margin-bottom: 24px;
            padding-bottom: 20px;
            border-bottom: 1px dashed var(--border-light);
        }

        .price-val {
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--primary);
        }

        .stock-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 700;
        }

        .stock-badge.available {
            background: #dcfce7;
            color: #15803d;
        }

        .stock-badge.empty {
            background: #fee2e2;
            color: #b91c1c;
        }

        .description-box {
            margin-bottom: 32px;
        }

        .description-box h4 {
            font-size: 1rem;
            color: var(--dark);
            margin-bottom: 10px;
            font-weight: 700;
        }

        .description-box p {
            color: var(--text-muted);
            font-size: 1rem;
            line-height: 1.7;
        }

        /* Perks List */
        .perks-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 36px;
            padding: 20px;
            background: var(--bg-light);
            border-radius: var(--radius-sm);
            border: 1px solid var(--border-light);
        }

        .perk-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-dark);
        }

        .perk-item i {
            color: var(--primary);
            font-size: 1.1rem;
        }

        /* Action Buttons */
        .action-group {
            display: flex;
            gap: 16px;
            align-items: center;
            margin-top: auto;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 16px 28px;
            border-radius: 30px;
            font-weight: 700;
            text-decoration: none;
            transition: var(--transition);
            cursor: pointer;
            border: none;
            font-size: 0.95rem;
        }

        .btn-whatsapp {
            background: #25D366;
            color: var(--white);
            flex: 1;
            box-shadow: 0 10px 20px rgba(37, 211, 102, 0.25);
        }

        .btn-whatsapp:hover {
            background: #1eb957;
            transform: translateY(-2px);
            box-shadow: 0 14px 28px rgba(37, 211, 102, 0.35);
        }

        .btn-back {
            background: var(--white);
            color: var(--text-dark);
            border: 1px solid var(--border-light);
        }

        .btn-back:hover {
            background: var(--primary-soft);
            color: var(--primary);
            border-color: rgba(10, 37, 64, 0.2);
        }

        /* Empty State Error */
        .not-found-card {
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 80px 20px;
            text-align: center;
            box-shadow: var(--shadow-sm);
            margin: 40px auto;
            max-width: 600px;
        }

        .not-found-card i {
            font-size: 4rem;
            color: var(--secondary);
            margin-bottom: 20px;
        }

        .not-found-card h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            margin-bottom: 12px;
            color: var(--dark);
        }

        .not-found-card p {
            color: var(--text-muted);
            margin-bottom: 28px;
        }

        /* Footer */
        .footer {
            background: var(--white);
            border-top: 1px solid var(--border-light);
            padding: 40px 0 24px;
            margin-top: auto;
        }

        .footer-bottom {
            text-align: center;
            color: var(--text-muted);
            font-size: 0.85rem;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .product-card-detail {
                grid-template-columns: 1fr;
                padding: 24px;
                gap: 32px;
            }
            .product-image {
                height: 360px;
            }
            .product-title {
                font-size: 2rem;
            }
        }

        @media (max-width: 576px) {
            .perks-grid {
                grid-template-columns: 1fr;
            }
            .action-group {
                flex-direction: column;
            }
            .btn {
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="container">
            <a href="index.php" class="brand">
                <i class="fa-solid fa-cake-candles"></i> BondoRoso
            </a>
            <ul class="nav-links">
                <li><a href="index.php">Beranda</a></li>
                <li><a href="produk.php" class="active">Katalog Produk</a></li>
                <li><a href="tentang.php">Tentang Kami</a></li>
                <li><a href="kontak.php">Kontak</a></li>
            </ul>
        </div>
    </nav>

    <div class="detail-wrapper">
        <div class="container">

            <?php if ($produk): ?>

                <!-- Breadcrumb Navigation -->
                <div class="breadcrumb">
                    <a href="index.php">Beranda</a>
                    <i class="fa-solid fa-chevron-right"></i>
                    <a href="produk.php">Produk</a>
                    <i class="fa-solid fa-chevron-right"></i>
                    <span><?= htmlspecialchars($produk['nama']); ?></span>
                </div>

                <!-- Product Detail Card -->
                <div class="product-card-detail">

                    <!-- Left: Media / Image -->
                    <div class="product-media">
                        <?php if (!empty($produk['kategori'])): ?>
                            <span class="category-badge">
                                <?= htmlspecialchars($produk['kategori']); ?>
                            </span>
                        <?php endif; ?>

                        <?php if (!empty($produk['gambar'])): ?>
                            <img src="uploads/produk/<?= htmlspecialchars($produk['gambar']); ?>" 
                                 alt="<?= htmlspecialchars($produk['nama']); ?>" 
                                 class="product-image"
                                 onerror="this.src='https://images.unsplash.com/photo-1578985545062-69928b1d9587?auto=format&fit=crop&w=800&q=80'">
                        <?php else: ?>
                            <img src="https://images.unsplash.com/photo-1578985545062-69928b1d9587?auto=format&fit=crop&w=800&q=80" 
                                 alt="Default Product" 
                                 class="product-image">
                        <?php endif; ?>
                    </div>

                    <!-- Right: Info Details -->
                    <div class="product-info">
                        <h1 class="product-title"><?= htmlspecialchars($produk['nama']); ?></h1>

                        <div class="price-container">
                            <span class="price-val">
                                Rp <?= number_format($produk['harga'], 0, ',', '.'); ?>
                            </span>

                            <?php if ($produk['stok'] > 0): ?>
                                <span class="stock-badge available">
                                    <i class="fa-solid fa-check-circle"></i> Stok: <?= $produk['stok']; ?>
                                </span>
                            <?php else: ?>
                                <span class="stock-badge empty">
                                    <i class="fa-solid fa-xmark-circle"></i> Stok Habis
                                </span>
                            <?php endif; ?>
                        </div>

                        <!-- Highlights / Guarantees -->
                        <div class="perks-grid">
                            <div class="perk-item">
                                <i class="fa-solid fa-cookie-bite"></i>
                                <span>Fresh Baked</span>
                            </div>
                            <div class="perk-item">
                                <i class="fa-solid fa-wheat-awn"></i>
                                <span>100% Organik</span>
                            </div>
                            <div class="perk-item">
                                <i class="fa-solid fa-truck-fast"></i>
                                <span>Kirim Cepat</span>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="description-box">
                            <h4>Deskripsi Produk</h4>
                            <p>
                                <?= !empty($produk['deskripsi']) 
                                    ? nl2br(htmlspecialchars($produk['deskripsi'])) 
                                    : 'Belum ada deskripsi khusus untuk produk ini.'; ?>
                            </p>
                        </div>

                        <!-- Action Buttons -->
                        <?php 
                            $waMessage = rawurlencode("Halo BondoRoso, saya ingin memesan produk *" . $produk['nama'] . "* seharga Rp " . number_format($produk['harga'], 0, ',', '.') . ".");
                        ?>
                        <div class="action-group">
                            <a href="https://wa.me/6281234567890?text=<?= $waMessage; ?>" 
                               target="_blank" 
                               class="btn btn-whatsapp">
                                <i class="fa-brands fa-whatsapp" style="font-size: 1.2rem;"></i> Pesan via WhatsApp
                            </a>
                            <a href="produk.php" class="btn btn-back">
                                <i class="fa-solid fa-arrow-left"></i> Kembali
                            </a>
                        </div>

                    </div>
                </div>

            <?php else: ?>

                <!-- Product Not Found View -->
                <div class="not-found-card">
                    <i class="fa-solid fa-cookie"></i>
                    <h2>Produk Tidak Ditemukan</h2>
                    <p>Maaf, kue yang Anda cari mungkin sudah tidak tersedia atau ID tidak valid.</p>
                    <a href="produk.php" class="btn btn-back" style="display: inline-flex;">
                        <i class="fa-solid fa-arrow-left"></i> Kembali ke Katalog Produk
                    </a>
                </div>

            <?php endif; ?>

        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-bottom">
                <p>&copy; <?= date('Y'); ?> BondoRoso. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>

</html>