<?php
session_start();
include 'config/database.php';

// Proteksi halaman: Jika belum login, tendang ke login.php
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['submit'])) {
    // Ambil data dan sanitasi untuk mencegah XSS
    $task_name = htmlspecialchars($_POST['task_name']);
    $user_id = $_SESSION['user_id'];

    // Gunakan Prepared Statement untuk keamanan SQL
    $stmt = $conn->prepare("INSERT INTO tasks (user_id, task_name) VALUES (?, ?)");
    $stmt->bind_param("is", $user_id, $task_name);

    if ($stmt->execute()) {
        header("Location: index.php"); // Kembali ke dashboard setelah sukses
        exit;
    } else {
        echo "Gagal menambah tugas: " . $conn->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Tugas</title>
</head>
<body>
    <h2>Tambah Tugas Baru</h2>
    <form method="POST" action="">
        <input type="text" name="task_name" placeholder="Tulis tugas anda..." required>
        <button type="submit" name="submit">Simpan Tugas</button>
    </form>
    <br>
    <a href="index.php">Kembali</a>
</body>
</html>