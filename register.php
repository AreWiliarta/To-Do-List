<?php
session_start();
include 'config/database.php';

// Jika tombol register ditekan
if (isset($_POST['register'])) {
    $username = htmlspecialchars($_POST['username']); // Sanitasi input
    $password = $_POST['password'];

    // Cek apakah username sudah ada
    $check_query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($result) > 0) {
        $error = "Username sudah digunakan!";
    } else {
        // Enkripsi password sebelum disimpan
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Masukkan ke database
        $insert_query = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";
        
        if (mysqli_query($conn, $insert_query)) {
            echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location='login.php';</script>";
        } else {
            $error = "Registrasi gagal: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register - Todo List</title>
    </head>
<body>
    <h2>Daftar Akun Baru</h2>
    <?php if(isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
    
    <form action="" method="POST">
        <label>Username:</label><br>
        <input type="text" name="username" required><br><br>
        
        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>
        
        <button type="submit" name="register">Daftar</button>
    </form>
    <p>Sudah punya akun? <a href="login.php">Login disini</a></p>
</body>
</html>