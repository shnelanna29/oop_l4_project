<?php
require 'db.php';
$stmt = $pdo->query("SELECT id, login, full_name, phone, email, created_at FROM users");
$users = $stmt->fetchAll();
echo "<h2>Пользователи</h2><table border='1'><tr><th>ID</th><th>Логин</th><th>ФИО</th><th>Телефон</th><th>Email</th><th>Дата регистрации</th></tr>";
foreach ($users as $user) {
    echo "<tr><td>{$user['id']}</td><td>{$user['login']}</td><td>{$user['full_name']}</td><td>{$user['phone']}</td><td>{$user['email']}</td><td>{$user['created_at']}</td></tr>";
}
echo "</table><p><a href='index.php?page=admin'>Назад</a></p>";
?>
