-- Tabel untuk menyimpan data user
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel tasks (untuk persiapan Anggota 2 nanti, biar sekalian)
CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    task_name VARCHAR(255) NOT NULL,
    status ENUM('pending', 'completed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- 1. Lihat daftar semua database yang ada
SHOW DATABASES;

-- 2. Masuk ke database 'todolist' (sesuaikan dengan nama di config/database.php)
USE todolist;

-- 3. Cek apakah tabel users benar-benar ada di dalam 'todolist'
SHOW TABLES;

SELECT * FROM users;