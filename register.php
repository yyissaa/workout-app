<?php
require 'config/database.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $goal = $_POST['goal'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $query = "INSERT INTO users (name, email, password, goal) VALUES ('$name', '$email', '$password', '$goal')";
    if (mysqli_query($conn, $query)) { header('Location: index.php'); exit; } 
    else { $error = "Email sudah terdaftar!"; }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - THRIVE</title>
    <!-- LINK CSS LANGSUNG -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="glass">
        <h1 class="neon-text">📝 <span>DAFTAR</span></h1>
        <p class="subtitle">GABUNG BERSAMA KAMI</p>
        <?php if (isset($error)) : ?><p class="error"><?= $error; ?></p><?php endif; ?>
        <form method="POST">
            <input type="text" name="name" placeholder="Nama Lengkap" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <select name="goal" required>
                <option value="Fat Loss">🔥 Fat Loss</option>
                <option value="Muscle Gain">💪 Muscle Gain</option>
                <option value="Endurance">🏃 Endurance</option>
                <option value="Strength">🏋️ Strength</option>
            </select>
            <button type="submit" class="btn-primary">Daftar</button>
        </form>
        <p style="text-align:center; margin-top:25px; color:#8b9bb4; font-size: 0.9rem;">
            Sudah punya akun? <a href="index.php" class="link">Login di sini</a>
        </p>
    </div>
</body>
</html>