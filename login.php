<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($login === '' || $password === '') {
        echo '<p>Введите логин и пароль.</p>';
        exit;
    }

    $stmt = $pdo->prepare("SELECT id, password, user_type_fk FROM `user` WHERE login = ?");
    $stmt->execute([$login]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role_id'] = $user['user_type_fk'];
        echo '<p>Вы успешно вошли. <a href="index.php">На главную</a></p>';
    } else {
        echo '<p>Неверный логин или пароль.</p>';
    }
} else {
    header('Location: index.php?page=login');
}
