<?php
require 'config/database.php';
if (!isset($_SESSION['user'])) header('Location: index.php');
$user = $_SESSION['user'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $goal = $_POST['goal'];
    mysqli_query($conn, "UPDATE users SET goal='$goal' WHERE id={$user['id']}");
    $_SESSION['user']['goal'] = $goal; $user = $_SESSION['user']; $success = "✅ Tujuan berhasil diupdate!";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - THRIVE</title>
    <!-- LINK CSS LANGSUNG -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="glass">
        <h1 class="neon-text" style="font-size:2rem;">👤 <span>PROFIL</span></h1>
        <?php if (isset($success)) echo "<p style='color:#ccff00; text-align:center;'>$success</p>"; ?>
        <div class="profile-avatar">👤</div>
        <div class="profile-info">
            <p class="label">Nama</p><p class="value"><?= $user['name'] ?></p>
            <p class="label">Email</p><p class="value" style="font-size:1rem;"><?= $user['email'] ?></p>
            <p class="label">Tujuan</p><p class="value goal"><?= $user['goal'] ?></p>
        </div>
        <form method="POST">
            <select name="goal" required>
                <option value="Fat Loss" <?= $user['goal']=='Fat Loss'?'selected':'' ?>>🔥 Fat Loss</option>
                <option value="Muscle Gain" <?= $user['goal']=='Muscle Gain'?'selected':'' ?>>💪 Muscle Gain</option>
                <option value="Endurance" <?= $user['goal']=='Endurance'?'selected':'' ?>>🏃 Endurance</option>
                <option value="Strength" <?= $user['goal']=='Strength'?'selected':'' ?>>🏋️ Strength</option>
            </select>
            <button type="submit" class="btn-primary">Update Tujuan</button>
        </form>
    </div>
    <div class="bottom-nav">
        <a href="dashboard.php"><span class="icon">🏠</span>Home</a>
        <a href="workouts.php"><span class="icon">📋</span>Workout</a>
        <a href="history.php"><span class="icon">📊</span>Riwayat</a>
        <a href="profile.php" class="active"><span class="icon">👤</span>Profil</a>
    </div>
</body>
</html>