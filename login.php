<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login    = trim($_POST['login'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($login === '' || $password === '') {
        echo "Введите логин и пароль.";
        exit;
    }

    $stmt = $pdo->prepare("SELECT id, password, user_type_fk FROM `user` WHERE login = ?");
    $stmt->execute([$login]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id']  = $user['id'];
        $_SESSION['role_id']  = $user['user_type_fk'];
        header("Location: index.php");
        exit;
    } else {
        echo "Неверный логин или пароль.";
        echo '<br><a href="index.php?page=login">Назад</a>';
    }
} else {
    header('Location: index.php?page=login');
    exit;
}
