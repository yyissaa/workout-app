<?php
require 'config/database.php';
if (!isset($_SESSION['user'])) header('Location: index.php');
$user_id = $_SESSION['user']['id'];
$user = $_SESSION['user'];
$history_count = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM user_workout_history WHERE user_id=$user_id"));
$recommended = mysqli_query($conn, "SELECT * FROM workouts ORDER BY RAND() LIMIT 4");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - THRIVE</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="glass">
        <div class="top-nav">
            <h1 class="neon-text" style="font-size:1.5rem;"><span>THRIVE</span></h1>
            <div>
                <!-- Teks nama diubah jadi putih -->
                <span style="color:black; font-weight:bold;">👤 <?= $user['name'] ?></span>
                <a href="logout.php" style="color:#f87171; margin-left:15px; text-decoration:none;">🚪</a>
            </div>
        </div>
        <div class="greeting">
            <h2>Halo, <span><?= $user['name'] ?></span>! 👋</h2>
            <p>Tujuan: <?= $user['goal'] ?> • Total: <?= $history_count ?> latihan</p>
        </div>
        <div class="progress-section">
            <p>Progress Minggu Ini</p>
            <div class="progress-bar"><div class="progress-fill" style="width: <?= min($history_count * 10, 100) ?>%;"></div></div>
        </div>
        <h3 style="margin:20px 0 10px; color:white;">🔥 Rekomendasi</h3>
        
        <div class="workout-grid">
            <?php while ($w = mysqli_fetch_assoc($recommended)): ?>
                <a href="workout_detail.php?id=<?= $w['id'] ?>" class="workout-card">
                    <img src="<?= !empty($w['image_url']) ? $w['image_url'] : 'https://images.unsplash.com/photo-1517836357463-d25dfeac3438?q=80&w=400&auto=format&fit=crop' ?>" alt="Workout">
                    
                    <h4><?= $w['name'] ?></h4>
                    <p><?= $w['muscle_group'] ?></p>
                    <span class="badge">⏱️ <?= round($w['duration']/60) ?> menit</span>
                </a>
            <?php endwhile; ?>
        </div>
    </div>
    <div class="bottom-nav">
        <a href="dashboard.php" class="active"><span class="icon">🏠</span>Home</a>
        <a href="workouts.php"><span class="icon">📋</span>Workout</a>
        <a href="history.php"><span class="icon">📊</span>Riwayat</a>
        <a href="profile.php"><span class="icon">👤</span>Profil</a>
    </div>
</body>
</html>