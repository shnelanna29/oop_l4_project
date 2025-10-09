<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE login = ?");
    $stmt->execute([$login]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        echo "<p>Вход выполнен! <a href='index.php'>Главная</a></p>";
    } else {
        echo "<p>Неправильный логин или пароль. <a href='index.php?page=login'>Попробовать снова</a></p>";
    }
} else {
    header("Location: index.php?page=login");
}
?>
