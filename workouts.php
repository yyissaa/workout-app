<?php
require 'config/database.php';
if (!isset($_SESSION['user'])) header('Location: index.php');
$filter = isset($_GET['filter']) ? $_GET['filter'] : '';
$query = "SELECT * FROM workouts";
if ($filter) $query .= " WHERE muscle_group='$filter'";
$workouts = mysqli_query($conn, $query);
$groups = mysqli_query($conn, "SELECT DISTINCT muscle_group FROM workouts");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workout - THRIVE</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="glass">
        <h1 class="neon-text" style="font-size:2rem;">📋 <span>WORKOUT</span></h1>
        <div class="filter-section">
            <a href="workouts.php" class="filter-btn <?= !$filter ? 'active' : '' ?>">Semua</a>
            <?php while ($g = mysqli_fetch_assoc($groups)): ?>
                <a href="workouts.php?filter=<?= $g['muscle_group'] ?>" class="filter-btn <?= $filter == $g['muscle_group'] ? 'active' : '' ?>"><?= $g['muscle_group'] ?></a>
            <?php endwhile; ?>
        </div>
        
        <div class="workout-grid">
            <?php while ($w = mysqli_fetch_assoc($workouts)): ?>
                <a href="workout_detail.php?id=<?= $w['id'] ?>" class="workout-card">
                    <img src="<?= !empty($w['image_url']) ? $w['image_url'] : 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?q=80&w=400&auto=format&fit=crop' ?>" alt="Workout">
                    
                    <h4><?= $w['name'] ?></h4>
                    <p><?= $w['muscle_group'] ?></p>
                    <span class="badge">⏱️ <?= round($w['duration']/60) ?> menit</span>
                </a>
            <?php endwhile; ?>
        </div>
    </div>
    <div class="bottom-nav">
        <a href="dashboard.php"><span class="icon">🏠</span>Home</a>
        <a href="workouts.php" class="active"><span class="icon">📋</span>Workout</a>
        <a href="history.php"><span class="icon">📊</span>Riwayat</a>
        <a href="profile.php"><span class="icon">👤</span>Profil</a>
    </div>
</body>
</html>