<?php
session_start();
include 'config/database.php';

// Jika user sudah login, alihkan ke index
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    // Cari user berdasarkan username
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    // Jika username ditemukan
    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        
        // Verifikasi password hash
        if (password_verify($password, $row['password'])) {
            // Set Session
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            
            header("Location: index.php"); // Pindah ke halaman utama
            exit;
        }
    }
    
    $error = "Username atau Password salah!";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Todo List</title>
</head>
<body>
    <h2>Login Aplikasi</h2>
    <?php if(isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
    
    <form action="" method="POST">
        <label>Username:</label><br>
        <input type="text" name="username" required><br><br>
        
        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>
        
        <button type="submit" name="login">Masuk</button>
    </form>
    <p>Belum punya akun? <a href="register.php">Daftar disini</a></p>
</body>
</html>