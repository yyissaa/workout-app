<?php
require 'config/database.php';
if (!isset($_SESSION['user'])) header('Location: index.php');
$id = $_GET['id'];
$workout = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM workouts WHERE id=$id"));
if (!$workout) { header('Location: workouts.php'); exit; }
$user_id = $_SESSION['user']['id'];

if (isset($_POST['complete'])) {
    $sets = $_POST['sets'] ?? 1;
    $duration = $workout['duration'] * $sets;
    mysqli_query($conn, "INSERT INTO user_workout_history (user_id, workout_id, sets_completed, total_duration) VALUES ($user_id, $id, $sets, $duration)");
    $success = "✅ Latihan selesai! Great job!";
}
function getYoutubeId($url) {
    preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&?]+)/', $url, $m);
    return $m[1] ?? '';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $workout['name'] ?> - THRIVE</title>
    <!-- LINK CSS LANGSUNG -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="glass">
        <h1 class="neon-text" style="font-size:2rem;"><?= $workout['name'] ?></h1>
        <p class="subtitle"><?= $workout['muscle_group'] ?> • ⏱️ <?= round($workout['duration']/60) ?> menit</p>
        <?php if (isset($success)) echo "<p style='color:#ccff00; text-align:center; margin-bottom:15px;'>$success</p>"; ?>
        <div style="margin:20px 0; border-radius:16px; overflow:hidden; border: 1px solid rgba(255,255,255,0.1);">
            <?php if ($workout['video_url']): ?>
                <iframe width="100%" height="250" src="https://www.youtube.com/embed/<?= getYoutubeId($workout['video_url']) ?>" frameborder="0" allowfullscreen style="display:block;"></iframe>
            <?php endif; ?>
        </div>
        <p style="color:#8b9bb4; margin-bottom:20px;"><?= $workout['description'] ?></p>
        <div class="timer-section">
            <h3>⏱️ WORKOUT TIMER</h3>
            <div id="timerDisplay">00:00</div>
            <div class="timer-controls">
                <button onclick="startTimer(<?= $workout['duration'] ?>)" class="btn-primary">▶️ Mulai</button>
                <button onclick="pauseTimer()" class="btn-secondary">⏸️ Jeda</button>
                <button onclick="resetTimer()" class="btn-secondary">⏹️ Reset</button>
            </div>
            <div style="margin-top:20px;">
                <label style="color:#8b9bb4;">Jumlah Set: </label>
                <input type="number" id="setCount" value="1" min="1" max="10" style="width:80px; padding:10px; text-align:center; margin-bottom:0;">
            </div>
        </div>
        <form method="POST" style="margin-top:20px;">
            <input type="hidden" name="sets" id="setsInput" value="1">
            <button type="submit" name="complete" class="btn-primary" style="background:#00f0ff;">✅ Selesai Latihan!</button>
        </form>
        <a href="workouts.php" class="link" style="display:block; text-align:center; margin-top:20px;">← Kembali ke daftar</a>
    </div>
    <script>
        let timerInterval = null, timeLeft = 0, isRunning = false, totalSeconds = 0;
        function startTimer(duration) {
            const sets = parseInt(document.getElementById('setCount').value) || 1;
            document.getElementById('setsInput').value = sets;
            totalSeconds = duration * sets;
            if (isRunning) return;
            if (timeLeft === 0) timeLeft = totalSeconds;
            isRunning = true; updateDisplay();
            timerInterval = setInterval(() => {
                timeLeft--; updateDisplay();
                if (timeLeft <= 0) {
                    clearInterval(timerInterval); isRunning = false; playBeep(); alert('⏰ Waktu habis! Great job! 💪');
                }
            }, 1000);
        }
        function pauseTimer() { clearInterval(timerInterval); isRunning = false; }
        function resetTimer() { clearInterval(timerInterval); isRunning = false; timeLeft = 0; updateDisplay(); }
        function updateDisplay() {
            const m = Math.floor(timeLeft / 60), s = timeLeft % 60;
            document.getElementById('timerDisplay').textContent = String(m).padStart(2,'0') + ':' + String(s).padStart(2,'0');
        }
        function playBeep() {
            try { const ctx = new (window.AudioContext || window.webkitAudioContext)(); const osc = ctx.createOscillator(), gain = ctx.createGain(); osc.connect(gain); gain.connect(ctx.destination); osc.frequency.value = 880; gain.gain.value = 0.3; osc.start(); osc.stop(ctx.currentTime + 0.3); } catch(e) {}
        }
        updateDisplay();
    </script>
    <div class="bottom-nav">
        <a href="dashboard.php"><span class="icon">🏠</span>Home</a>
        <a href="workouts.php" class="active"><span class="icon">📋</span>Workout</a>
        <a href="history.php"><span class="icon">📊</span>Riwayat</a>
        <a href="profile.php"><span class="icon">👤</span>Profil</a>
    </div>
</body>
</html>