<?php
session_start();
include 'config/database.php';

// 1. Cek apakah user sudah login

// Cek apakah user sudah login, jika belum lempar ke login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// 2. Ambil data tugas dari database khusus milik user yang login
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM tasks WHERE user_id = $user_id ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Todo List</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <div class="container">
        <header>
            <h1>Halo, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
            <a href="logout.php" class="btn-logout">Logout</a>
        </header>

        <div class="action-bar">
            <a href="add_task.php" class="btn-add">+ Tambah Tugas Baru</a>
        </div>

        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Tugas</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Tentukan warna status
                        $status_label = ($row['status'] == 'completed') ? 'Selesai' : 'Belum Selesai';
                        $status_class = ($row['status'] == 'completed') ? 'status-done' : 'status-pending';
                        
                        // Coret teks jika selesai
                        $task_name = ($row['status'] == 'completed') ? "<strike>{$row['task_name']}</strike>" : $row['task_name'];
                ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $task_name; ?></td>
                        <td><span class="<?php echo $status_class; ?>"><?php echo $status_label; ?></span></td>
                        <td>
                            <a href="edit_task.php?id=<?php echo $row['id']; ?>" class="btn-edit">Edit</a>
                            
                            <a href="delete_task.php?id=<?php echo $row['id']; ?>" 
                               class="btn-delete" 
                               onclick="return confirm('Yakin ingin menghapus tugas ini?');">Hapus</a>
                        </td>
                    </tr>
                <?php 
                    }
                } else {
                    echo "<tr><td colspan='4' align='center'>Belum ada tugas. Yuk tambah tugas baru!</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
<script src="assets/js/script.js"></script>


