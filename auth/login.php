<?php

session_start();

if (isset($_SESSION['admin_id'])) {
    header("Location: ../admin/index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - BondoRoso</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;1,400&display=swap" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --navy-deep: #0f172a;
            --navy-dark: #1e293b;
            --navy-primary: #1e3a8a;
            --navy-light: #3b82f6;
            --navy-subtle: #f0fdf4;
            --accent-gold: #d97706;
            --accent-gold-hover: #b45309;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --bg-body: #090d16;
            --card-bg: #ffffff;
            --input-bg: #f8fafc;
            --border-color: #e2e8f0;
            --shadow-glow: 0 20px 40px -15px rgba(30, 58, 138, 0.35);
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
            background-image: 
                radial-gradient(circle at 15% 20%, rgba(30, 58, 138, 0.35) 0%, transparent 40%),
                radial-gradient(circle at 85% 80%, rgba(217, 119, 6, 0.15) 0%, transparent 40%),
                radial-gradient(circle at 50% 50%, rgba(15, 23, 42, 0.8) 0%, var(--bg-body) 100%);
            background-attachment: fixed;
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            position: relative;
            overflow-x: hidden;
        }

        /* Decorative Background Elements */
        body::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: linear-gradient(135deg, #1e3a8a, #3b82f6);
            border-radius: 50%;
            top: -100px;
            right: -100px;
            opacity: 0.2;
            filter: blur(80px);
            z-index: 0;
        }

        .login-wrapper {
            width: 100%;
            max-width: 440px;
            position: relative;
            z-index: 1;
        }

        /* Brand Logo */
        .brand-logo {
            text-align: center;
            margin-bottom: 24px;
        }

        .brand-logo a {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            font-weight: 700;
            color: #ffffff;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            letter-spacing: 0.5px;
            transition: var(--transition);
        }

        .brand-logo a i {
            color: var(--accent-gold);
            background: rgba(217, 119, 6, 0.15);
            padding: 12px;
            border-radius: 16px;
            border: 1px solid rgba(217, 119, 6, 0.3);
            font-size: 1.5rem;
        }

        .brand-logo a:hover {
            transform: translateY(-2px);
        }

        /* Login Card */
        .login-card {
            background: var(--card-bg);
            border-radius: 24px;
            padding: 40px;
            box-shadow: var(--shadow-glow), 0 10px 25px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            position: relative;
        }

        .login-header {
            text-align: center;
            margin-bottom: 28px;
        }

        .login-header h1 {
            font-size: 1.65rem;
            font-weight: 800;
            color: var(--navy-deep);
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .login-header p {
            color: var(--text-muted);
            font-size: 0.9rem;
            line-height: 1.5;
        }

        /* Alert Notification */
        .alert {
            background-color: #fef2f2;
            border-left: 4px solid #ef4444;
            color: #991b1b;
            padding: 14px 16px;
            border-radius: 12px;
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 2px 8px rgba(239, 68, 68, 0.08);
            animation: slideIn 0.3s ease-out forwards;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Form Controls */
        .form-group {
            margin-bottom: 22px;
        }

        .form-group label {
            display: block;
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--navy-dark);
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }

        .input-group {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-group i.input-icon {
            position: absolute;
            left: 16px;
            color: #94a3b8;
            font-size: 1.05rem;
            transition: var(--transition);
        }

        .input-group input {
            width: 100%;
            padding: 14px 44px 14px 48px;
            border: 1.5px solid var(--border-color);
            border-radius: 14px;
            font-family: inherit;
            font-size: 0.95rem;
            color: var(--text-main);
            background-color: var(--input-bg);
            transition: var(--transition);
            outline: none;
        }

        .input-group input:focus {
            border-color: var(--navy-primary);
            background-color: #ffffff;
            box-shadow: 0 0 0 4px rgba(30, 58, 138, 0.12);
        }

        .input-group input:focus + i.input-icon,
        .input-group input:focus ~ i.input-icon {
            color: var(--navy-primary);
        }

        /* Password Toggle Button */
        .toggle-password {
            position: absolute;
            right: 16px;
            color: #94a3b8;
            cursor: pointer;
            font-size: 1rem;
            padding: 4px;
            transition: var(--transition);
        }

        .toggle-password:hover {
            color: var(--navy-primary);
        }

        /* Submit Button */
        .btn-submit {
            width: 100%;
            background: linear-gradient(135deg, var(--navy-primary) 0%, #1e40af 100%);
            color: #ffffff;
            border: none;
            padding: 15px;
            border-radius: 14px;
            font-weight: 700;
            font-size: 0.95rem;
            cursor: pointer;
            transition: var(--transition);
            margin-top: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 8px 20px rgba(30, 58, 138, 0.3);
        }

        .btn-submit:hover {
            background: linear-gradient(135deg, #1e40af 0%, #1d4ed8 100%);
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(30, 58, 138, 0.4);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        /* Navigasi Kembali */
        .back-link {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 26px;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 600;
            transition: var(--transition);
        }

        .back-link:hover {
            color: var(--navy-primary);
        }

        .back-link i {
            transition: var(--transition);
        }

        .back-link:hover i {
            transform: translateX(-4px);
        }

        /* Responsive Tweaks */
        @media (max-width: 480px) {
            .login-card {
                padding: 30px 22px;
                border-radius: 20px;
            }
            .brand-logo a {
                font-size: 1.8rem;
            }
        }
    </style>
</head>

<body>

    <div class="login-wrapper">

        <div class="brand-logo">
            <a href="../index.php">
                <i class="fa-solid fa-cake-candles"></i> BondoRoso
            </a>
        </div>

        <div class="login-card">
            <div class="login-header">
                <h1>Login Admin</h1>
                <p>Masukkan kredensial Anda untuk mengelola toko BondoRoso</p>
            </div>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span><?= htmlspecialchars($_SESSION['error']); ?></span>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <form action="proses_login.php" method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <div class="input-group">
                        <i class="fa-solid fa-user input-icon"></i>
                        <input type="text" id="username" name="username" placeholder="Masukkan username admin" required autofocus autocomplete="username">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-group">
                        <i class="fa-solid fa-lock input-icon"></i>
                        <input type="password" id="password" name="password" placeholder="Masukkan password" required autocomplete="current-password">
                        <i class="fa-solid fa-eye toggle-password" id="togglePassword" title="Lihat Password"></i>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fa-solid fa-right-to-bracket"></i> Masuk Sekarang
                </button>
            </form>

            <a href="../index.php" class="back-link">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Website Utama
            </a>
        </div>

    </div>

    <script>
        // Fitur Toggle Show/Hide Password
        const togglePassword = document.querySelector('#togglePassword');
        const passwordInput = document.querySelector('#password');

        togglePassword.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>

</body>

</html>