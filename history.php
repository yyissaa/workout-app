<?php
require 'config/database.php';
if (!isset($_SESSION['user'])) header('Location: index.php');
$user_id = $_SESSION['user']['id'];

// PERHATIKAN: Kita tambahkan w.image_url di sini biar fotonya ketarik
$history = mysqli_query($conn, "SELECT h.*, w.name, w.muscle_group, w.image_url 
    FROM user_workout_history h 
    JOIN workouts w ON h.workout_id = w.id 
    WHERE h.user_id = $user_id 
    ORDER BY h.completed_at DESC LIMIT 20");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat - THRIVE</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="glass">
        <h1 class="neon-text" style="font-size:2rem;">📊 <span>RIWAYAT</span></h1>
        <?php if (mysqli_num_rows($history) == 0): ?>
            <p style="color:#8b9bb4; text-align:center; margin-top:20px;">Belum ada riwayat. Yuk mulai latihan! 💪</p>
        <?php else: ?>
            <?php while ($h = mysqli_fetch_assoc($history)): ?>
                <div class="history-item">
                    
                    <!-- Variabel diganti jadi $h['image_url'] -->
                    <img src="<?= !empty($h['image_url']) ? $h['image_url'] : 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?q=80&w=400&auto=format&fit=crop' ?>" alt="Workout">
                    
                    <div class="info">
                        <h4><?= $h['name'] ?></h4>
                        <p><?= $h['muscle_group'] ?> • <?= $h['sets_completed'] ?> set</p>
                        <!-- Tanggal dibikin agak gelap biar kebaca -->
                        <small style="color:#333; font-weight:bold;"><?= date('d M Y H:i', strtotime($h['completed_at'])) ?></small>
                    </div>
                    
                    <span class="status">✅</span>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
    <div class="bottom-nav">
        <a href="dashboard.php"><span class="icon">🏠</span>Home</a>
        <a href="workouts.php"><span class="icon">📋</span>Workout</a>
        <a href="history.php" class="active"><span class="icon">📊</span>Riwayat</a>
        <a href="profile.php"><span class="icon">👤</span>Profil</a>
    </div>
</body>
</html>