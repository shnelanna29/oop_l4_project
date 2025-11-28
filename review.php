<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'] ?? null;

    if (!$user_id) {
        echo '<p>Войдите в систему, чтобы оставить отзыв. <a href="index.php?page=login">Войти</a></p>';
        exit;
    }

    if (!isset($_POST['request_fk'], $_POST['review_text'])) {
        echo '<p>Ошибка: заполните все поля.</p>';
        exit;
    }

    $request_fk = (int)$_POST['request_fk'];
    $review_text = trim($_POST['review_text']);

    $stmt = $pdo->prepare("
        INSERT INTO review (user_fk, request_fk, date, review_text)
        VALUES (?, ?, CURDATE(), ?)
    ");
    $stmt->execute([$user_id, $request_fk, $review_text]);

    echo '<p>Отзыв сохранён! <a href="index.php">Главная</a></p>';
} else {
    header('Location: index.php?page=review');
}
