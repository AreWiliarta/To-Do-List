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
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Tugas</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container"> <h2>Tambah Tugas Baru</h2>
        <form method="POST" action="">
            <div class="form-group">
                <input type="text" name="task_name" placeholder="Tulis tugas anda..." required>
            </div>
            <button type="submit" name="submit" class="btn-add">Simpan Tugas</button>
            <a href="index.php" class="btn-logout" style="background: gray;">Batal</a>
        </form>
    </div>
</body>
</html>