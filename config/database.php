<?php
// config/database.php

$hostname = "localhost";
$username = "root";
$password = "Wiliarta36#"; // Kosongkan jika pakai XAMPP default
$database = "todolist";

$conn = mysqli_connect($hostname, $username, $password, $database);

if (!$conn) {
    die("Koneksi Database Gagal: " . mysqli_connect_error());
}
?>