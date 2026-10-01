<?php

require_once __DIR__ . '/../config/database.php';

/*
|--------------------------------------------------------------------------
| DATA ADMIN
|--------------------------------------------------------------------------
*/

$nama = "Administrator";
$username = "admin";
$password = "admin123";

$berhasil = false;
$sudahAda = false;
$error = "";


/*
|--------------------------------------------------------------------------
| CEK DATABASE
|--------------------------------------------------------------------------
*/

if (!$conn) {
    $error = "Koneksi database gagal.";
} else {

    /*
    |--------------------------------------------------------------------------
    | CEK APAKAH USERNAME SUDAH ADA
    |--------------------------------------------------------------------------
    */

    $cek = mysqli_prepare(
        $conn,
        "SELECT id FROM admin WHERE username = ? LIMIT 1"
    );

    if (!$cek) {

        $error = "Gagal melakukan pengecekan username.";

    } else {

        mysqli_stmt_bind_param(
            $cek,
            "s",
            $username
        );

        mysqli_stmt_execute($cek);

        mysqli_stmt_store_result($cek);

        if (mysqli_stmt_num_rows($cek) > 0) {

            $sudahAda = true;

        } else {

            /*
            |--------------------------------------------------------------------------
            | HASH PASSWORD
            |--------------------------------------------------------------------------
            */

            $password_hash = password_hash(
                $password,
                PASSWORD_DEFAULT
            );


            /*
            |--------------------------------------------------------------------------
            | INSERT ADMIN
            |--------------------------------------------------------------------------
            */

            $stmt = mysqli_prepare(
                $conn,
                "INSERT INTO admin (nama, username, password)
                 VALUES (?, ?, ?)"
            );

            if (!$stmt) {

                $error = "Gagal menyiapkan data admin.";

            } else {

                mysqli_stmt_bind_param(
                    $stmt,
                    "sss",
                    $nama,
                    $username,
                    $password_hash
                );


                if (mysqli_stmt_execute($stmt)) {

                    $berhasil = true;

                } else {

                    $error = "Gagal membuat admin: " .
                             mysqli_stmt_error($stmt);
                }

                mysqli_stmt_close($stmt);
            }
        }

        mysqli_stmt_close($cek);
    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inisialisasi Admin - BondoRoso</title>

    <!-- GOOGLE FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@600;700&display=swap" rel="stylesheet">

    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --navy-bg: #0b132b;
            --navy-card: rgba(30, 41, 59, 0.75);
            --navy-card-border: rgba(255, 255, 255, 0.08);
            --navy-inner: #0f172a;
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --accent-blue: #3b82f6;
            --accent-glow: rgba(59, 130, 246, 0.25);
            --success: #10b981;
            --success-bg: rgba(16, 185, 129, 0.12);
            --warning: #f59e0b;
            --warning-bg: rgba(245, 158, 11, 0.12);
            --danger: #ef4444;
            --danger-bg: rgba(239, 68, 68, 0.12);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: 
                radial-gradient(circle at 15% 15%, #1e3a8a 0%, transparent 45%),
                radial-gradient(circle at 85% 85%, #1e1b4b 0%, transparent 45%),
                linear-gradient(135deg, #0f172a 0%, #020617 100%);
            color: var(--text-primary);
            position: relative;
            overflow-x: hidden;
        }

        /* Ambient Glow Orbs */
        .orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(90px);
            pointer-events: none;
            z-index: 1;
        }

        .orb-1 {
            width: 320px;
            height: 320px;
            background: rgba(59, 130, 246, 0.18);
            top: -60px;
            left: -60px;
        }

        .orb-2 {
            width: 380px;
            height: 380px;
            background: rgba(99, 102, 241, 0.14);
            bottom: -80px;
            right: -60px;
        }

        /* Admin Card Container */
        .admin-card {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 490px;
            margin: 24px;
            padding: 42px;
            background: var(--navy-card);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 24px;
            border: 1px solid var(--navy-card-border);
            box-shadow: 
                0 25px 50px -12px rgba(0, 0, 0, 0.5),
                0 0 0 1px rgba(255, 255, 255, 0.05);
        }

        /* Logo & Header */
        .logo {
            text-align: center;
            margin-bottom: 32px;
        }

        .logo-icon {
            width: 68px;
            height: 68px;
            margin: 0 auto 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 20px;
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            color: #ffffff;
            font-size: 28px;
            box-shadow: 0 10px 25px var(--accent-glow);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        .logo h1 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: -0.5px;
            color: #ffffff;
            margin-bottom: 4px;
        }

        .logo p {
            color: var(--text-secondary);
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        /* Alert Box */
        .alert {
            padding: 18px 20px;
            border-radius: 16px;
            margin-bottom: 24px;
            display: flex;
            gap: 14px;
            align-items: flex-start;
            border: 1px solid transparent;
        }

        .alert-icon {
            width: 38px;
            height: 38px;
            min-width: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            font-size: 16px;
        }

        .alert h3 {
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .alert p {
            font-size: 13px;
            line-height: 1.5;
            opacity: 0.9;
        }

        /* Alert Variations */
        .alert-success {
            background: var(--success-bg);
            border-color: rgba(16, 185, 129, 0.25);
            color: #34d399;
        }
        .alert-success .alert-icon {
            background: rgba(16, 185, 129, 0.2);
            color: #10b981;
        }

        .alert-warning {
            background: var(--warning-bg);
            border-color: rgba(245, 158, 11, 0.25);
            color: #fbbf24;
        }
        .alert-warning .alert-icon {
            background: rgba(245, 158, 11, 0.2);
            color: #f59e0b;
        }

        .alert-error {
            background: var(--danger-bg);
            border-color: rgba(239, 68, 68, 0.25);
            color: #f87171;
        }
        .alert-error .alert-icon {
            background: rgba(239, 68, 68, 0.2);
            color: #ef4444;
        }

        /* Account Details Box */
        .account-info {
            background: var(--navy-inner);
            border: 1px solid var(--navy-card-border);
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 24px;
        }

        .account-info-title {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--text-secondary);
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            font-size: 13px;
        }

        .info-row:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .info-row:first-of-type {
            padding-top: 0;
        }

        .info-label {
            color: var(--text-secondary);
            font-weight: 500;
        }

        .info-value {
            font-weight: 600;
            color: #ffffff;
            font-family: monospace;
            background: rgba(255, 255, 255, 0.06);
            padding: 4px 10px;
            border-radius: 6px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .status-badge {
            font-family: inherit;
            font-weight: 600;
            color: #fbbf24;
            background: rgba(245, 158, 11, 0.15);
            padding: 4px 10px;
            border-radius: 6px;
        }

        /* Buttons */
        .btn {
            width: 100%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 14px 24px;
            border-radius: 12px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 700;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: #ffffff;
            box-shadow: 0 10px 20px -5px rgba(37, 99, 235, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            transform: translateY(-2px);
            box-shadow: 0 14px 26px -5px rgba(37, 99, 235, 0.5);
        }

        /* Footer */
        .footer {
            text-align: center;
            margin-top: 28px;
            color: #64748b;
            font-size: 12px;
            font-weight: 500;
        }

        @media (max-width: 520px) {
            .admin-card {
                padding: 28px 20px;
                margin: 16px;
            }

            .logo h1 {
                font-size: 24px;
            }
        }
    </style>

</head>

<body>

    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>

    <div class="admin-card">

        <!-- LOGO -->
        <div class="logo">
            <div class="logo-icon">
                <i class="fa-solid fa-cake-candles"></i>
            </div>
            <h1>BondoRoso</h1>
            <p>Administrator Initialization</p>
        </div>

        <?php if ($berhasil): ?>

            <!-- SUCCESS -->
            <div class="alert alert-success">
                <div class="alert-icon">
                    <i class="fa-solid fa-check"></i>
                </div>
                <div>
                    <h3>Admin Berhasil Dibuat!</h3>
                    <p>Akun administrator baru berhasil didaftarkan ke sistem.</p>
                </div>
            </div>

            <div class="account-info">
                <div class="account-info-title">
                    <i class="fa-solid fa-user-shield"></i>
                    Informasi Akun
                </div>

                <div class="info-row">
                    <span class="info-label">Nama</span>
                    <span class="info-value"><?= htmlspecialchars($nama); ?></span>
                </div>

                <div class="info-row">
                    <span class="info-label">Username</span>
                    <span class="info-value"><?= htmlspecialchars($username); ?></span>
                </div>

                <div class="info-row">
                    <span class="info-label">Password</span>
                    <span class="info-value"><?= htmlspecialchars($password); ?></span>
                </div>
            </div>

            <a href="login.php" class="btn btn-primary">
                <i class="fa-solid fa-right-to-bracket"></i>
                Login ke Admin
            </a>

        <?php elseif ($sudahAda): ?>

            <!-- USERNAME SUDAH ADA -->
            <div class="alert alert-warning">
                <div class="alert-icon">
                    <i class="fa-solid fa-circle-exclamation"></i>
                </div>
                <div>
                    <h3>Admin Sudah Terdaftar</h3>
                    <p>Username <strong><?= htmlspecialchars($username); ?></strong> sudah ada di sistem database.</p>
                </div>
            </div>

            <div class="account-info">
                <div class="account-info-title">
                    <i class="fa-solid fa-shield-halved"></i>
                    Informasi Login
                </div>

                <div class="info-row">
                    <span class="info-label">Username</span>
                    <span class="info-value"><?= htmlspecialchars($username); ?></span>
                </div>

                <div class="info-row">
                    <span class="info-label">Status</span>
                    <span class="status-badge">Aktif di Database</span>
                </div>
            </div>

            <a href="login.php" class="btn btn-primary">
                <i class="fa-solid fa-right-to-bracket"></i>
                Ke Halaman Login
            </a>

        <?php else: ?>

            <!-- ERROR -->
            <div class="alert alert-error">
                <div class="alert-icon">
                    <i class="fa-solid fa-xmark"></i>
                </div>
                <div>
                    <h3>Terjadi Kesalahan</h3>
                    <p><?= htmlspecialchars($error); ?></p>
                </div>
            </div>

            <a href="buat_admin.php" class="btn btn-primary">
                <i class="fa-solid fa-rotate-right"></i>
                Coba Lagi
            </a>

        <?php endif; ?>

        <div class="footer">
            BondoRoso &copy; <?= date('Y'); ?> &bull; All Rights Reserved
        </div>

    </div>

</body>

</html>