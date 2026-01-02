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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Todo List</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="login-page">

    <div class="auth-container">
        <div class="auth-box">
            <h2>Daftar Akun Baru</h2>
            <p>Silakan isi data untuk mendaftar</p>

            <?php if(isset($error)) { echo "<p style='color:red; margin-bottom:15px;'>$error</p>"; } ?>
            
            <form action="" method="POST">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="Buat username" required>
                </div>
                
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Buat password" required>
                </div>
                
                <button type="submit" name="register" class="btn-primary">Daftar Sekarang</button>
            </form>

            <p class="auth-footer">
                Sudah punya akun? <a href="login.php">Login di sini</a>
            </p>
        </div>
    </div>

</body>
</html>