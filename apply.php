<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'] ?? null;

    if (!$user_id) {
        echo '<p>Войдите в систему, чтобы оставить заявку. <a href="index.php?page=login">Войти</a></p>';
        exit;
    }

    if (!isset($_POST['cours_fk'], $_POST['date'], $_POST['cash_fk'])) {
        echo '<p>Ошибка: заполните все поля.</p>';
        exit;
    }

    $cours_fk = (int)$_POST['cours_fk'];
    $date     = $_POST['date'];
    $cash_fk  = (int)$_POST['cash_fk'];

    // статус "новая" (id = 1)
    $status_fk = 1;

    $stmt = $pdo->prepare(
        "INSERT INTO request (date, user_fk, cours_fk, status_fk, cash_fk)
         VALUES (?, ?, ?, ?, ?)"
    );
    $stmt->execute([$date, $user_id, $cours_fk, $status_fk, $cash_fk]);

    echo '<p>Заявка отправлена! <a href="index.php">Главная</a></p>';
} else {
    header('Location: index.php?page=application');
}
