<?php
session_start();
include 'config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$id = $_GET['id'];

// 1. Ambil data tugas berdasarkan ID dan pastikan milik user yang login
$stmt = $conn->prepare("SELECT * FROM tasks WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    die("Tugas tidak ditemukan atau anda tidak memiliki akses.");
}

// 2. Proses Update jika tombol diklik
if (isset($_POST['update'])) {
    $task_name = htmlspecialchars($_POST['task_name']);
    $status = $_POST['status'];

    $update_stmt = $conn->prepare("UPDATE tasks SET task_name = ?, status = ? WHERE id = ? AND user_id = ?");
    $update_stmt->bind_param("ssii", $task_name, $status, $id, $user_id);

    if ($update_stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        echo "Gagal mengupdate: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tugas - Todo List</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="login-page">

    <div class="auth-container">
        <div class="auth-box">
            <h2>Edit Tugas</h2>
            <p>Perbarui detail tugas Anda</p>

            <form method="POST" action="">
                <div class="form-group">
                    <label>Nama Tugas</label>
                    <input type="text" name="task_name" value="<?= htmlspecialchars($data['task_name']); ?>" required>
                </div>

                <div class="form-group">
                    <label>Status Tugas</label>
                    <select name="status" class="form-select">
                        <option value="pending" <?= $data['status'] == 'pending' ? 'selected' : ''; ?>>Belum Selesai</option>
                        <option value="completed" <?= $data['status'] == 'completed' ? 'selected' : ''; ?>>Selesai</option>
                    </select>
                </div>

                <button type="submit" name="update" class="btn-primary">Update Tugas</button>
                
                <div class="auth-footer">
                    <a href="index.php" style="color: #666;">Batal dan Kembali</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>