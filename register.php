<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'] ?? '';
    $password = $_POST['password'] ?? '';
    $fio = $_POST['fullname'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $email = $_POST['email'] ?? '';

    if ($login === '' || $password === '' || $fio === '') {
        echo '<p>Заполните обязательные поля.</p>';
        exit;
    }

    $stmt = $pdo->prepare("SELECT id FROM `user` WHERE login = ?");
    $stmt->execute([$login]);
    if ($stmt->fetch()) {
        echo '<p>Такой логин уже существует.</p>';
        exit;
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);

    // роль по умолчанию student (id = 1)
    $stmt = $pdo->prepare("
        INSERT INTO `user` (login, password, FIO, phone, email, user_type_fk)
        VALUES (?, ?, ?, ?, ?, 1)
    ");
    $stmt->execute([$login, $hash, $fio, $phone, $email]);

    echo '<p>Регистрация успешна. <a href="index.php?page=login">Войти</a></p>';
} else {
    header('Location: index.php?page=register');
}
