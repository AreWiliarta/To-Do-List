<?php
session_start();

// Cek apakah user sudah login, jika belum lempar ke login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h1>Selamat Datang, <?php echo $_SESSION['username']; ?>!</h1>
    <p>Ini adalah halaman utama Todo List.</p>
    
    <a href="logout.php">Logout</a>
</body>
</html>