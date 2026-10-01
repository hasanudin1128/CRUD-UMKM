<?php

require_once __DIR__ . "/config/database.php";

$query = mysqli_query(
    $conn,
    "SELECT * FROM produk
     ORDER BY id DESC
     LIMIT 6"
);

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BondoRoso - Toko Kue Lezat & Premium</title>

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
        }

        /* Container */
        .container {
            max-width: 1240px;
            margin: 0 auto;
            padding: 0 24px;
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
            transition: var(--transition);
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
            letter-spacing: -0.5px;
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
            position: relative;
        }

        .nav-links a:hover,
        .nav-links a.active {
            color: var(--primary);
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -6px;
            left: 50%;
            transform: translateX(-50%);
            width: 0%;
            height: 3px;
            background: var(--primary);
            transition: var(--transition);
            border-radius: 4px;
        }

        .nav-links a:hover::after,
        .nav-links a.active::after {
            width: 100%;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, #f0f4f9 0%, #e1e9f4 50%, #d8e3f2 100%);
            padding: 80px 0 100px;
            border-radius: 0 0 var(--radius-lg) var(--radius-lg);
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -120px;
            right: -120px;
            width: 500px;
            height: 500px;
            background: rgba(10, 37, 64, 0.08);
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            gap: 48px;
            align-items: center;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--white);
            color: var(--primary);
            padding: 8px 18px;
            border-radius: 30px;
            font-size: 0.85rem;
            font-weight: 700;
            margin-bottom: 24px;
            box-shadow: var(--shadow-sm);
            border: 1px solid rgba(10, 37, 64, 0.12);
        }

        .hero-badge i {
            color: var(--secondary);
        }

        .hero h1 {
            font-family: 'Playfair Display', serif;
            font-size: 3.8rem;
            line-height: 1.15;
            color: var(--dark);
            margin-bottom: 20px;
            font-weight: 700;
        }

        .hero h1 span {
            color: var(--primary);
            font-style: italic;
        }

        .hero p {
            font-size: 1.15rem;
            color: var(--text-muted);
            margin-bottom: 36px;
            max-width: 540px;
        }

        .btn-group {
            display: flex;
            gap: 16px;
            align-items: center;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 15px 30px;
            border-radius: 30px;
            font-weight: 700;
            text-decoration: none;
            transition: var(--transition);
            cursor: pointer;
            border: none;
            font-size: 0.95rem;
        }

        .btn-primary {
            background: var(--primary);
            color: var(--white);
            box-shadow: 0 10px 25px rgba(10, 37, 64, 0.25);
        }

        .btn-primary:hover {
            background: var(--primary-hover);
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(10, 37, 64, 0.35);
        }

        .btn-outline {
            background: var(--white);
            color: var(--text-dark);
            border: 1px solid rgba(10, 37, 64, 0.12);
            box-shadow: var(--shadow-sm);
        }

        .btn-outline:hover {
            border-color: var(--primary);
            color: var(--primary);
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
        }

        /* Hero Visual / Floating Cards */
        .hero-visual {
            position: relative;
            display: flex;
            justify-content: center;
        }

        .hero-card-featured {
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 20px;
            box-shadow: var(--shadow-lg);
            width: 100%;
            max-width: 380px;
            position: relative;
            transform: rotate(-2deg);
            transition: var(--transition);
        }

        .hero-card-featured:hover {
            transform: rotate(0deg) scale(1.02);
        }

        .hero-card-img {
            width: 100%;
            height: 280px;
            object-fit: cover;
            border-radius: var(--radius-md);
        }

        .floating-badge {
            position: absolute;
            background: var(--white);
            padding: 12px 20px;
            border-radius: 20px;
            box-shadow: var(--shadow-md);
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 700;
            font-size: 0.85rem;
            z-index: 10;
        }

        .badge-1 {
            top: 20px;
            left: -30px;
            animation: float 4s ease-in-out infinite;
        }

        .badge-2 {
            bottom: 20px;
            right: -20px;
            animation: float 4s ease-in-out infinite 2s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        /* Features Section */
        .features-section {
            margin-top: -40px;
            margin-bottom: 60px;
            position: relative;
            z-index: 20;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            background: var(--white);
            padding: 32px;
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border-light);
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .feature-icon {
            width: 52px;
            height: 52px;
            border-radius: 16px;
            background: var(--primary-soft);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            flex-shrink: 0;
        }

        .feature-text h4 {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--dark);
        }

        .feature-text p {
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        /* Section Header */
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin: 40px 0 36px 0;
        }

        .section-title h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2.4rem;
            color: var(--dark);
            font-weight: 700;
        }

        .section-title p {
            color: var(--text-muted);
            font-size: 0.98rem;
            margin-top: 6px;
        }

        .link-more {
            color: var(--primary);
            text-decoration: none;
            font-weight: 700;
            font-size: 0.95rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: var(--transition);
        }

        .link-more:hover {
            gap: 12px;
            color: var(--secondary);
        }

        /* Grid Products */
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
            gap: 32px;
            margin-bottom: 80px;
        }

        .card {
            background: var(--white);
            border-radius: var(--radius-md);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-light);
            transition: var(--transition);
            display: flex;
            flex-direction: column;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-lg);
            border-color: rgba(10, 37, 64, 0.2);
        }

        .card-image-wrapper {
            position: relative;
            width: 100%;
            padding-top: 72%;
            overflow: hidden;
            background: #f1f5f9;
        }

        .product-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .card:hover .product-image {
            transform: scale(1.08);
        }

        .badge-kategori {
            position: absolute;
            top: 16px;
            left: 16px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(8px);
            color: var(--primary);
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 800;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            box-shadow: 0 4px 12px rgba(10, 37, 64, 0.08);
        }

        .rating-badge {
            position: absolute;
            top: 16px;
            right: 16px;
            background: rgba(7, 17, 30, 0.8);
            backdrop-filter: blur(8px);
            color: var(--white);
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .rating-badge i {
            color: var(--secondary);
        }

        .card-body {
            padding: 24px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .card-body h3 {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 8px;
            color: var(--dark);
            line-height: 1.35;
        }

        .card-price-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto;
            padding-top: 20px;
            border-top: 1px dashed var(--border-light);
        }

        .price-label {
            font-size: 0.75rem;
            color: var(--text-muted);
            text-transform: uppercase;
            font-weight: 600;
        }

        .price-tag {
            font-size: 1.35rem;
            font-weight: 800;
            color: var(--primary);
            line-height: 1;
        }

        .btn-detail {
            padding: 12px 20px;
            border-radius: 14px;
            background: var(--primary-soft);
            color: var(--primary);
            text-decoration: none;
            font-weight: 700;
            font-size: 0.88rem;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-detail:hover {
            background: var(--primary);
            color: var(--white);
            box-shadow: 0 6px 15px rgba(10, 37, 64, 0.3);
        }

        .empty-state {
            grid-column: 1 / -1;
            text-align: center;
            padding: 80px 20px;
            background: var(--white);
            border-radius: var(--radius-md);
            color: var(--text-muted);
            border: 1px dashed #cbd5e1;
        }

        /* Banner CTA */
        .cta-banner {
            background: linear-gradient(135deg, var(--dark) 0%, var(--primary) 100%);
            border-radius: var(--radius-lg);
            padding: 60px 40px;
            color: var(--white);
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 80px;
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-lg);
        }

        .cta-banner::after {
            content: '';
            position: absolute;
            right: -50px;
            bottom: -50px;
            width: 300px;
            height: 300px;
            background: rgba(217, 119, 6, 0.18);
            border-radius: 50%;
            filter: blur(60px);
        }

        .cta-content h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            margin-bottom: 12px;
        }

        .cta-content p {
            color: #cbd5e1;
            max-width: 500px;
            font-size: 1rem;
        }

        /* Footer */
        .footer {
            background: var(--white);
            border-top: 1px solid var(--border-light);
            padding: 60px 0 30px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 40px;
            margin-bottom: 40px;
        }

        .footer-brand p {
            color: var(--text-muted);
            margin-top: 16px;
            font-size: 0.9rem;
            max-width: 320px;
        }

        .footer-col h4 {
            font-size: 1rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 20px;
        }

        .footer-col ul {
            list-style: none;
        }

        .footer-col ul li {
            margin-bottom: 12px;
        }

        .footer-col ul li a {
            text-decoration: none;
            color: var(--text-muted);
            font-size: 0.9rem;
            transition: var(--transition);
        }

        .footer-col ul li a:hover {
            color: var(--primary);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid var(--border-light);
            color: var(--text-muted);
            font-size: 0.85rem;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .hero-grid { grid-template-columns: 1fr; gap: 40px; text-align: center; }
            .hero-content { max-width: 100%; }
            .hero p { margin-left: auto; margin-right: auto; }
            .btn-group { justify-content: center; }
            .features-grid { grid-template-columns: repeat(2, 1fr); }
            .cta-banner { flex-direction: column; text-align: center; gap: 24px; }
            .footer-grid { grid-template-columns: 1fr 1fr; }
        }

        @media (max-width: 768px) {
            .hero h1 { font-size: 2.6rem; }
            .section-header { flex-direction: column; align-items: flex-start; gap: 12px; }
            .grid { grid-template-columns: 1fr; }
            .features-grid { grid-template-columns: 1fr; }
            .nav-links { display: none; }
            .footer-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="container">
            <a href="index.php" class="brand">
                <i class="fa-solid fa-cake-candles"></i>  BondoRoso
            </a>
            <ul class="nav-links">
                <li><a href="index.php" class="active">Beranda</a></li>
                <li><a href="produk.php">Katalog Produk</a></li>
                <li><a href="tentang.php">Tentang Kami</a></li>
                <li><a href="kontak.php">Kontak</a></li>
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-grid">
                <div class="hero-content">
                    <span class="hero-badge">
                        <i class="fa-solid fa-star"></i> Toko Kue Pilihan Utama
                    </span>
                    <h1>Kelezatan Autentik Di Setiap <span>Gigitan.</span></h1>
                    <p>Dibuat secara handmade dari bahan-bahan organik berkualitas tinggi. Sempurna untuk memanjakan lidah dan memeriahkan momen istimewa Anda.</p>
                    <div class="btn-group">
                        <a href="produk.php" class="btn btn-primary">
                            <i class="fa-solid fa-store"></i> Jelajahi Produk
                        </a>
                        <a href="tentang.php" class="btn btn-outline">
                            Tentang Kami
                        </a>
                    </div>
                </div>

                <div class="hero-visual">
                    <div class="floating-badge badge-1">
                        <i class="fa-solid fa-fire-flame-curved" style="color: var(--secondary);"></i>
                        <span>100% Freshly Baked</span>
                    </div>

                    <div class="hero-card-featured">
                        <img src="https://images.unsplash.com/photo-1578985545062-69928b1d9587?auto=format&fit=crop&w=800&q=80" alt="Kue Unggulan" class="hero-card-img">
                    </div>

                    <div class="floating-badge badge-2">
                        <i class="fa-solid fa-heart" style="color: #e11d48;"></i>
                        <span>Rating 4.9/5 (1.2k+ Ulasan)</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="container">

        <!-- Features / Keunggulan -->
        <div class="features-section">
            <div class="features-grid">
                <div class="feature-item">
                    <div class="feature-icon"><i class="fa-solid fa-wheat-awn"></i></div>
                    <div class="feature-text">
                        <h4>Bahan Premium</h4>
                        <p>100% Organik & Alami</p>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon"><i class="fa-solid fa-truck-fast"></i></div>
                    <div class="feature-text">
                        <h4>Pengiriman Cepat</h4>
                        <p>Aman sampai tujuan</p>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon"><i class="fa-solid fa-heart"></i></div>
                    <div class="feature-text">
                        <h4>Dibuat Dengan Cinta</h4>
                        <p>Resep koki profesional</p>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon"><i class="fa-solid fa-wand-magic-sparkles"></i></div>
                    <div class="feature-text">
                        <h4>Desain Custom</h4>
                        <p>Sesuai keinginan Anda</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section Header -->
        <div class="section-header">
            <div class="section-title">
                <h2>Koleksi Terbaru</h2>
                <p>Pilihan kue terfavorit yang baru saja disajikan hari ini</p>
            </div>
            <a href="produk.php" class="link-more">
                Lihat Semua Produk <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        <!-- Product Grid -->
        <div class="grid">
            <?php if (mysqli_num_rows($query) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($query)): ?>
                    <div class="card">
                        <div class="card-image-wrapper">
                            <?php if (!empty($row['kategori'])): ?>
                                <span class="badge-kategori">
                                    <?= htmlspecialchars($row['kategori']); ?>
                                </span>
                            <?php endif; ?>

                            <span class="rating-badge">
                                <i class="fa-solid fa-star"></i> 4.9
                            </span>

                            <?php if (!empty($row['gambar'])): ?>
                                <img src="uploads/produk/<?= htmlspecialchars($row['gambar']); ?>" 
                                     alt="<?= htmlspecialchars($row['nama']); ?>" 
                                     class="product-image"
                                     onerror="this.src='https://images.unsplash.com/photo-1578985545062-69928b1d9587?auto=format&fit=crop&w=600&q=80'">
                            <?php else: ?>
                                <img src="https://images.unsplash.com/photo-1578985545062-69928b1d9587?auto=format&fit=crop&w=600&q=80" alt="Default Product" class="product-image">
                            <?php endif; ?>
                        </div>

                        <div class="card-body">
                            <h3><?= htmlspecialchars($row['nama']); ?></h3>

                            <div class="card-price-row">
                                <div>
                                    <div class="price-label">Harga</div>
                                    <div class="price-tag">
                                        Rp <?= number_format($row['harga'], 0, ',', '.'); ?>
                                    </div>
                                </div>
                                <a href="detail.php?id=<?= $row['id']; ?>" class="btn-detail">
                                    Detail <i class="fa-solid fa-chevron-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="empty-state">
                    <i class="fa-solid fa-box-open" style="font-size: 3.5rem; margin-bottom: 16px; color: var(--primary);"></i>
                    <h3>Belum Ada Produk</h3>
                    <p>Produk kue lezat kami akan segera hadir dalam waktu dekat.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Banner Call To Action -->
        <div class="cta-banner">
            <div class="cta-content">
                <h2>Pesan Kue Custom Untuk Acara Spesial Anda</h2>
                <p>Ulang tahun, pernikahan, atau anniversary? Kami siap mewujudkan kue impian Anda dengan rasa istimewa.</p>
            </div>
            <a href="https://wa.me/6281234567890" target="_blank" class="btn btn-primary" style="background: var(--white); color: var(--primary);">
                <i class="fa-brands fa-whatsapp" style="font-size: 1.2rem; color: #25D366;"></i> Hubungi Kami
            </a>
        </div>

    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <a href="index.php" class="brand">
                        <i class="fa-solid fa-cake-candles"></i> BondoRoso
                    </a>
                    <p>Menyediakan aneka kue kering, kue basah, dan kue ulang tahun lezat berbahan premium sejak 2020.</p>
                </div>
                <div class="footer-col">
                    <h4>Navigasi</h4>
                    <ul>
                        <li><a href="index.php">Beranda</a></li>
                        <li><a href="produk.php">Produk</a></li>
                        <li><a href="tentang.php">Tentang Kami</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Kategori</h4>
                    <ul>
                        <li><a href="#">Birthday Cake</a></li>
                        <li><a href="#">Pastry & Bakery</a></li>
                        <li><a href="#">Custom Cake</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Kontak</h4>
                    <ul>
                        <li><i class="fa-solid fa-location-dot"></i> Jl. Kebon Jeruk No. 12</li>
                        <li><i class="fa-solid fa-phone"></i> +62 812 3456 7890</li>
                        <li><i class="fa-solid fa-envelope"></i> info@BondoRoso.com</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?= date('Y'); ?> BondoRoso. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>

</html>