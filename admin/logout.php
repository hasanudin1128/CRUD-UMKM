<?php
session_start();

/*
|--------------------------------------------------------------------------
| 1. Hapus semua variabel session
|--------------------------------------------------------------------------
*/
$_SESSION = [];

/*
|--------------------------------------------------------------------------
| 2. Hapus cookie session dari browser
|--------------------------------------------------------------------------
*/
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

/*
|--------------------------------------------------------------------------
| 3. Hancurkan session di server
|--------------------------------------------------------------------------
*/
session_destroy();
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Redirect Otomatis setelah 2 detik jika JavaScript nonaktif -->
    <meta http-equiv="refresh" content="2;url=../auth/login.php">
    <title>Logout - BondoRoso Admin</title>

    <!-- Google Fonts & Font Awesome Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
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
            
            /* Warna Aksen */
            --amber-accent: #d97706;
            --emerald-accent: #10b981;
            --text-muted: #94a3b8;
            --white: #ffffff;
            
            --radius-lg: 24px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: radial-gradient(circle at top right, #1e3a8a 0%, #0f172a 45%, #090d16 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            color: var(--white);
            overflow: hidden;
            position: relative;
        }

        /* Elemen Dekorasi Latar Belakang (Glow Effects) */
        .bg-glow-1 {
            position: absolute;
            width: 350px;
            height: 350px;
            background: rgba(37, 99, 235, 0.2);
            filter: blur(100px);
            border-radius: 50%;
            top: -50px;
            left: -50px;
            pointer-events: none;
        }

        .bg-glow-2 {
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(217, 119, 6, 0.12);
            filter: blur(90px);
            border-radius: 50%;
            bottom: -50px;
            right: -50px;
            pointer-events: none;
        }

        /* Logout Card Container */
        .logout-card {
            background: rgba(17, 26, 46, 0.75);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: var(--radius-lg);
            padding: 44px 36px;
            max-width: 440px;
            width: 100%;
            text-align: center;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            animation: cardAppear 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            position: relative;
            z-index: 10;
        }

        @keyframes cardAppear {
            0% {
                opacity: 0;
                transform: translateY(20px) scale(0.96);
            }
            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* Icon Wrapper & Animations */
        .icon-container {
            width: 86px;
            height: 86px;
            margin: 0 auto 24px;
            background: rgba(37, 99, 235, 0.15);
            border: 2px solid rgba(37, 99, 235, 0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .icon-container i {
            font-size: 2.2rem;
            color: #60a5fa;
            animation: pulseIcon 2s infinite ease-in-out;
        }

        @keyframes pulseIcon {
            0%, 100% {
                transform: scale(1);
                color: #60a5fa;
            }
            50% {
                transform: scale(1.1);
                color: #93c5fd;
            }
        }

        .badge-brand {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 14px;
            background: rgba(217, 119, 6, 0.15);
            border: 1px solid rgba(217, 119, 6, 0.3);
            color: #fcd34d;
            border-radius: 20px;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-bottom: 16px;
        }

        /* Typography */
        .logout-card h2 {
            font-family: 'Playfair Display', serif;
            font-size: 1.85rem;
            font-weight: 700;
            color: var(--white);
            margin-bottom: 10px;
        }

        .logout-card p {
            font-size: 0.92rem;
            color: var(--text-muted);
            line-height: 1.6;
            margin-bottom: 28px;
        }

        /* Loading Progress Bar */
        .progress-bar-container {
            width: 100%;
            height: 6px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 24px;
        }

        .progress-bar-fill {
            height: 100%;
            width: 0%;
            background: linear-gradient(90deg, var(--navy-accent) 0%, var(--amber-accent) 100%);
            border-radius: 10px;
            animation: fillProgress 1.5s ease-in-out forwards;
        }

        @keyframes fillProgress {
            0% { width: 0%; }
            100% { width: 100%; }
        }

        /* Direct Redirect Button */
        .btn-redirect {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 24px;
            background: rgba(255, 255, 255, 0.06);
            color: #cbd5e1;
            text-decoration: none;
            font-size: 0.88rem;
            font-weight: 600;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.12);
            transition: var(--transition);
        }

        .btn-redirect:hover {
            background: var(--navy-accent);
            color: var(--white);
            border-color: var(--navy-accent);
            transform: translateY(-2px);
        }
    </style>
</head>

<body>

    <!-- Glow Decoration -->
    <div class="bg-glow-1"></div>
    <div class="bg-glow-2"></div>

    <!-- Main Transition Card -->
    <div class="logout-card">
        
        <div class="badge-brand">
            <i class="fa-solid fa-cake-candles"></i> BondoRoso Admin
        </div>

        <div class="icon-container">
            <i class="fa-solid fa-right-from-bracket"></i>
        </div>

        <h2>Sampai Jumpa!</h2>
        <p>Sesi Anda telah berhasil diakhiri secara aman. Anda akan dialihkan ke halaman login dalam beberapa detik.</p>

        <!-- Progress Indicator -->
        <div class="progress-bar-container">
            <div class="progress-bar-fill"></div>
        </div>

        <!-- Manual Link fallback -->
        <a href="../auth/login.php" class="btn-redirect">
            <span>Kembali ke Login Sekarang</span>
            <i class="fa-solid fa-arrow-right"></i>
        </a>

    </div>

    <!-- JavaScript Auto Redirect -->
    <script>
        setTimeout(function() {
            window.location.href = "../auth/login.php";
        }, 1500);
    </script>

</body>

</html>