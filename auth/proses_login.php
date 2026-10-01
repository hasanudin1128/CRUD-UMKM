<?php
session_start();

require_once "../config/database.php";

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

/*
|--------------------------------------------------------------------------
| VALIDASI INPUT
|--------------------------------------------------------------------------
*/
if (empty($username) || empty($password)) {
    $_SESSION['error'] = "Username dan password wajib diisi.";
    header("Location: login.php");
    exit;
}

if (!$conn) {
    $_SESSION['error'] = "Koneksi database gagal.";
    header("Location: login.php");
    exit;
}

/*
|--------------------------------------------------------------------------
| CARI ADMIN (PREPARED STATEMENT)
|--------------------------------------------------------------------------
*/
$stmt = mysqli_prepare($conn, "SELECT id, nama, username, password FROM admin WHERE username = ? LIMIT 1");

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $admin = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    /*
    |--------------------------------------------------------------------------
    | VERIFIKASI PASSWORD & LOGIN
    |--------------------------------------------------------------------------
    */
    if ($admin && password_verify($password, $admin['password'])) {
        session_regenerate_id(true);

        $_SESSION['admin_id']       = $admin['id'];
        $_SESSION['admin_nama']     = $admin['nama'];
        $_SESSION['admin_username'] = $admin['username'];

        header("Location: ../admin/index.php");
        exit;
    }
}

/*
|--------------------------------------------------------------------------
| LOGIN GAGAL
|--------------------------------------------------------------------------
*/
$_SESSION['error'] = "Username atau password salah.";
header("Location: login.php");
exit;