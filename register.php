<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login    = $_POST['login'] ?? '';
    $password = $_POST['password'] ?? '';
    $fio      = $_POST['fio'] ?? '';
    $phone    = $_POST['phone'] ?? '';
    $email    = $_POST['email'] ?? '';

    if ($login === '' || $password === '' || $fio === '') {
        echo "Заполните обязательные поля.";
        exit;
    }

    // Проверка уникальности логина
    $stmt = $pdo->prepare("SELECT id FROM `user` WHERE login = ?");
    $stmt->execute([$login]);
    if ($stmt->fetch()) {
        echo "Такой логин уже существует.";
        exit;
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("
        INSERT INTO `user` (login, password, FIO, phone, email, user_type_fk)
        VALUES (?, ?, ?, ?, ?, 1)
    ");
    $stmt->execute([$login, $hash, $fio, $phone, $email]);

    header("Location: index.php?page=login");
    exit;
}
