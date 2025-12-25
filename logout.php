<?php
session_start();
session_unset();
session_destroy();

// Kembalikan ke halaman login
header("Location: login.php");
exit;
?>