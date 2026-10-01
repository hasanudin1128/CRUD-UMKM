<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - BondoRoso</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;1,400&display=swap" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --navy-dark: #0f172a;
            --navy-primary: #1e293b;
            --navy-light: #334155;
            --navy-accent: #1e3a8a;
            --gold: #f59e0b;
            --gold-hover: #d97706;
            --accent-soft: #f8fafc;
            --white: #ffffff;
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --shadow-sm: 0 4px 6px -1px rgba(15, 23, 42, 0.05);
            --shadow-md: 0 10px 15px -3px rgba(15, 23, 42, 0.08);
            --shadow-lg: 0 20px 25px -5px rgba(15, 23, 42, 0.12), 0 8px 10px -6px rgba(15, 23, 42, 0.04);
            --radius-sm: 12px;
            --radius-md: 20px;
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
            background-color: #f1f5f9;
            color: var(--text-dark);
            line-height: 1.7;
            overflow-x: hidden;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }

        /* Navbar Modern */
        .navbar {
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(16px);
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
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
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--white);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            letter-spacing: -0.5px;
        }

        .brand i {
            color: var(--gold);
            font-size: 1.6rem;
        }

        .nav-links {
            display: flex;
            gap: 36px;
            list-style: none;
        }

        .nav-links a {
            text-decoration: none;
            color: #cbd5e1;
            font-weight: 500;
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

        /* Header Hero */
        .page-header {
            background: linear-gradient(135deg, var(--navy-dark) 0%, var(--navy-primary) 60%, var(--navy-accent) 100%);
            padding: 80px 0 100px;
            position: relative;
            overflow: hidden;
            text-align: center;
            color: var(--white);
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -20%;
            width: 140%;
            height: 200%;
            background: radial-gradient(circle, rgba(245, 158, 11, 0.08) 0%, rgba(0,0,0,0) 60%);
            pointer-events: none;
        }

        .badge-tag {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(245, 158, 11, 0.15);
            border: 1px solid rgba(245, 158, 11, 0.3);
            color: var(--gold);
            padding: 6px 16px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .page-header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 3.2rem;
            font-weight: 700;
            margin-bottom: 16px;
            letter-spacing: -0.5px;
        }

        .page-header p {
            color: #94a3b8;
            font-size: 1.15rem;
            max-width: 620px;
            margin: 0 auto;
        }

        /* Stats Bar Dynamic */
        .stats-wrapper {
            margin-top: -50px;
            position: relative;
            z-index: 10;
            margin-bottom: 64px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            background: var(--white);
            border-radius: var(--radius-md);
            padding: 32px;
            box-shadow: var(--shadow-lg);
            border: 1px solid rgba(226, 232, 240, 0.8);
            gap: 24px;
        }

        .stat-item {
            text-align: center;
            padding: 12px;
            border-right: 1px solid #f1f5f9;
        }

        .stat-item:last-child {
            border-right: none;
        }

        .stat-number {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--navy-dark);
            margin-bottom: 4px;
        }

        .stat-label {
            font-size: 0.85rem;
            color: var(--text-muted);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Grid Layout Utama */
        .story-section {
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
            gap: 40px;
            align-items: center;
            margin-bottom: 72px;
        }

        .about-card {
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 48px;
            box-shadow: var(--shadow-md);
            border: 1px solid rgba(226, 232, 240, 0.8);
            position: relative;
        }

        .about-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 48px;
            width: 60px;
            height: 4px;
            background: var(--gold);
            border-radius: 0 0 4px 4px;
        }

        .section-subtitle {
            color: var(--gold-hover);
            font-weight: 700;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
            display: block;
        }

        .about-card h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            color: var(--navy-dark);
            margin-bottom: 20px;
            line-height: 1.3;
        }

        .about-card p {
            color: var(--text-muted);
            font-size: 1.02rem;
            line-height: 1.8;
            margin-bottom: 20px;
        }

        .about-card p strong {
            color: var(--navy-primary);
        }

        .banner-box {
            background: linear-gradient(135deg, var(--navy-primary) 0%, var(--navy-dark) 100%);
            border-radius: var(--radius-lg);
            padding: 40px;
            color: var(--white);
            box-shadow: var(--shadow-lg);
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .banner-box i.bg-icon {
            position: absolute;
            right: -20px;
            bottom: -20px;
            font-size: 10rem;
            color: rgba(255, 255, 255, 0.03);
            pointer-events: none;
        }

        .banner-box h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            margin-bottom: 12px;
            color: var(--gold);
        }

        .banner-box p {
            color: #cbd5e1;
            font-size: 0.95rem;
            margin-bottom: 24px;
        }

        .banner-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            background: var(--gold);
            color: var(--navy-dark);
            font-weight: 700;
            padding: 14px 28px;
            border-radius: 50px;
            text-decoration: none;
            transition: var(--transition);
            width: fit-content;
        }

        .banner-btn:hover {
            background: #ffffff;
            color: var(--navy-dark);
            transform: translateY(-2px);
        }

        /* Features Section */
        .features-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .features-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            color: var(--navy-dark);
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 28px;
            margin-bottom: 80px;
        }

        .feature-card {
            background: var(--white);
            padding: 40px 32px;
            border-radius: var(--radius-md);
            border: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            text-align: center;
            position: relative;
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
            border-color: rgba(245, 158, 11, 0.3);
        }

        .feature-icon {
            width: 70px;
            height: 70px;
            background: #fef3c7;
            color: var(--gold-hover);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin: 0 auto 24px auto;
            transition: var(--transition);
        }

        .feature-card:hover .feature-icon {
            background: var(--navy-primary);
            color: var(--gold);
        }

        .feature-card h3 {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--navy-dark);
            margin-bottom: 12px;
        }

        .feature-card p {
            color: var(--text-muted);
            font-size: 0.95rem;
            line-height: 1.6;
        }

        /* Contact Section */
        .contact-section {
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 56px;
            box-shadow: var(--shadow-md);
            border: 1px solid rgba(226, 232, 240, 0.8);
            margin-bottom: 80px;
        }

        .contact-header {
            text-align: center;
            margin-bottom: 44px;
        }

        .contact-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            color: var(--navy-dark);
        }

        .contact-header p {
            color: var(--text-muted);
            font-size: 1rem;
            margin-top: 6px;
        }

        .contact-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 24px;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 24px;
            background: #f8fafc;
            border-radius: var(--radius-md);
            text-decoration: none;
            color: var(--text-dark);
            transition: var(--transition);
            border: 1px solid #e2e8f0;
        }

        .contact-item:hover {
            background: var(--navy-dark);
            color: var(--white);
            border-color: var(--navy-dark);
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
        }

        .contact-icon {
            width: 54px;
            height: 54px;
            border-radius: 14px;
            background: var(--white);
            color: var(--navy-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            box-shadow: var(--shadow-sm);
            flex-shrink: 0;
            transition: var(--transition);
        }

        .contact-item:hover .contact-icon {
            background: rgba(255, 255, 255, 0.15);
            color: var(--gold);
        }

        .contact-info h4 {
            font-size: 0.8rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
            transition: var(--transition);
        }

        .contact-item:hover .contact-info h4 {
            color: #94a3b8;
        }

        .contact-info p {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--navy-dark);
            transition: var(--transition);
        }

        .contact-item:hover .contact-info p {
            color: var(--white);
        }

        /* Footer */
        footer {
            background: var(--navy-dark);
            color: #94a3b8;
            padding: 32px 0;
            text-align: center;
            font-size: 0.9rem;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        footer span {
            color: var(--gold);
        }

        /* Responsive Breakpoints */
        @media (max-width: 992px) {
            .story-section {
                grid-template-columns: 1fr;
            }
            .stats-item {
                border-right: none;
                border-bottom: 1px solid #f1f5f9;
                padding-bottom: 20px;
            }
            .stats-item:last-child {
                border-bottom: none;
                padding-bottom: 0;
            }
        }

        @media (max-width: 768px) {
            .page-header h1 { font-size: 2.3rem; }
            .about-card, .contact-section { padding: 28px; }
            .nav-links { gap: 20px; }
            .contact-grid { grid-template-columns: 1fr; }
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
                <li><a href="produk.php">Produk</a></li>
                <li><a href="tentang.php" class="active">Tentang Kami</a></li>
            </ul>
        </div>
    </nav>

    <!-- Header Section -->
    <section class="page-header">
        <div class="container">
            <span class="badge-tag"><i class="fa-solid fa-crown"></i> UMKM Kuliner Premium</span>
            <h1>Tentang BondoRoso</h1>
            <p>Mengenal lebih dekat cerita, nilai dedikasi, serta kehangatan di balik setiap sajian manis kami.</p>
        </div>
    </section>

    <!-- Main Content -->
    <main class="container">

        <!-- Stats Bar -->
        <div class="stats-wrapper">
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-number">100%</div>
                    <div class="stat-label">Bahan Alami</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">5.000+</div>
                    <div class="stat-label">Pesanan Terlayani</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">4.9 / 5</div>
                    <div class="stat-label">Kepuasan Pelanggan</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">Fresh</div>
                    <div class="stat-label">Dipanggang Tiap Hari</div>
                </div>
            </div>
        </div>

        <!-- Story Section -->
        <section class="story-section">
            <div class="about-card">
                <span class="section-subtitle">Perjalanan Kami</span>
                <h2>Seni Pembuatan Kue Berawal dari Cinta & Resep Autentik</h2>
                <p>
                    <strong>BondoRoso</strong> adalah usaha mikro, kecil, dan menengah (UMKM) lokal yang berdedikasi dalam menghadirkan kelezatan kue berkualitas tinggi. Berawal dari kecintaan kami terhadap seni patiseri, kami terus berkomitmen menyajikan cita rasa rasa yang autentik, tekstur yang lembut, dan kehangatan di setiap gigitan.
                </p>
                <p>
                    Kami menyediakan beraneka ragam pilihan kue istimewa untuk memeriahkan momen berharga Anda—mulai dari hantaran keluarga, acara ulang tahun, pernikahan, hingga perayaan spesial lainnya.
                </p>
            </div>

            <div class="banner-box">
                <i class="fa-solid fa-cookie-bite bg-icon"></i>
                <h3>Pesan Kue Kustom Anda!</h3>
                <p>Ingin kue dengan desain khusus atau opsi rasa spesial? Tim kami siap mewujudkan kue impian Anda.</p>
                <a href="https://wa.me/6281234567890" target="_blank" class="banner-btn">
                    <i class="fa-brands fa-whatsapp"></i> Konsultasi Gratis
                </a>
            </div>
        </section>

        <!-- Features Grid -->
        <section style="margin-bottom: 80px;">
            <div class="features-header">
                <span class="section-subtitle">Keunggulan Kami</span>
                <h2>Mengapa Memilih BondoRoso</h2>
            </div>

            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fa-solid fa-wheat-awn"></i>
                    </div>
                    <h3>Bahan Segar & Premium</h3>
                    <p>Kami hanya menggunakan mentega murni, cokelat pilihan, dan bahan alami terbaik tanpa pengawet buatan.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fa-solid fa-heart"></i>
                    </div>
                    <h3>Dibuat Penuh Dedikasi</h3>
                    <p>Setiap kue dihias dan dibuat secara higienis oleh staf berpengalaman dengan standar kualitas tinggi.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fa-solid fa-truck-fast"></i>
                    </div>
                    <h3>Pasti Fresh & Tepat Waktu</h3>
                    <p>Dipanggang langsung di hari pengiriman untuk memastikan kue sampai di tangan Anda dalam kondisi puncak.</p>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section class="contact-section">
            <div class="contact-header">
                <span class="section-subtitle">Layanan Pelanggan</span>
                <h2>Hubungi Tim Kami</h2>
                <p>Punya pertanyaan atau ingin melakukan pemesanan? Hubungi kami melalui kanal di bawah ini.</p>
            </div>

            <div class="contact-grid">
                <a href="https://wa.me/6281234567890" target="_blank" class="contact-item">
                    <div class="contact-icon" style="color: #25D366;">
                        <i class="fa-brands fa-whatsapp"></i>
                    </div>
                    <div class="contact-info">
                        <h4>WhatsApp</h4>
                        <p>+62 812-3456-7890</p>
                    </div>
                </a>

                <a href="https://instagram.com/BondoRoso" target="_blank" class="contact-item">
                    <div class="contact-icon" style="color: #E4405F;">
                        <i class="fa-brands fa-instagram"></i>
                    </div>
                    <div class="contact-info">
                        <h4>Instagram</h4>
                        <p>@BondoRoso</p>
                    </div>
                </a>

                <div class="contact-item">
                    <div class="contact-icon" style="color: #0284c7;">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <div class="contact-info">
                        <h4>Lokasi Toko</h4>
                        <p>Jl. Mawar No. 12, Indonesia</p>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> <span>BondoRoso</span>. Seluruh Hak Cipta Dilindungi.</p>
        </div>
    </footer>

</body>

</html>