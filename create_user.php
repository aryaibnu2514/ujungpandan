<?php
require 'config.php';

$username = 'admin';
$password = password_hash('admin', PASSWORD_DEFAULT);
$role = 'admin';

$stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
$stmt->execute([$username, $password, $role]);

echo "User admin berhasil dibuat dengan password 'admin'.";
?>