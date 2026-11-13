<?php
require 'config/database.php';

if (isset($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    $user = mysqli_fetch_assoc($query);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user;
        header('Location: dashboard.php');
        exit;
    } else {
        $error = "Email atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - THRIVE App</title>
    
    <!-- LINK CSS LANGSUNG KE FILE SEBELAH -->
    <link rel="stylesheet" href="style.css">
    
</head>
<body>
    <div class="glass">
        <h1 class="neon-text"><span>THRIVE</span></h1>
        <p class="subtitle">MULAI PERJALANAN FITNESMU</p>
        
        <?php if (isset($error)) : ?>
            <p class="error"><?= $error; ?></p>
        <?php endif; ?>

        <form method="POST">
            <input type="email" name="email" placeholder="Email" required autocomplete="off">
            <input type="password" name="password" placeholder="Password" required>
            
            <button type="submit" class="btn-primary">Login</button>
        </form>
        
        <p style="text-align:center; margin-top:25px; color:var(--text-muted); font-size: 0.9rem;">
            Belum punya akun? <a href="register.php" class="link">Daftar sekarang</a>
        </p>
    </div>
</body>
</html>