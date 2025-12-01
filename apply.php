<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_SESSION['user_id'])) {
        echo "Войдите в систему, чтобы оставить заявку.";
        echo '<br><a href="index.php?page=login">Войти</a>';
        exit;
    }

    if (!isset($_POST['cours_fk'], $_POST['date'], $_POST['cash_fk']) ||
        $_POST['cours_fk'] === '' || $_POST['date'] === '' || $_POST['cash_fk'] === '') {
        echo "Ошибка: заполните все поля.";
        echo '<br><a href="index.php?page=application">Назад</a>';
        exit;
    }

    $user_id = (int)$_SESSION['user_id'];
    $cours_fk = (int)$_POST['cours_fk'];
    $date = $_POST['date'];
    $cash_fk = (int)$_POST['cash_fk'];

    // статус "новая" (id = 1)
    $status_fk = 1;

    $stmt = $pdo->prepare("
        INSERT INTO request (date, user_fk, cours_fk, status_fk, cash_fk)
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->execute([$date, $user_id, $cours_fk, $status_fk, $cash_fk]);

    echo "Заявка отправлена!";
    echo '<br><a href="index.php">Главная</a>';
} else {
    header('Location: index.php?page=application');
    exit;
}
