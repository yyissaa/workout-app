<?php
$host = 'localhost:3306';
$user = 'root';
$pass = '';
$db = 'workout_app';

$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) die("Koneksi gagal: " . mysqli_connect_error());

session_start();
?>