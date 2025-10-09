<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'] ?? null;
    if (!$user_id) {
        echo "<p>Войдите в систему чтобы оставить отзыв. <a href='index.php?page=login'>Войти</a></p>";
        exit;
    }

    if (!isset($_POST['course_id'], $_POST['review_text'], $_POST['rating'])) {
        echo "<p>Ошибка: заполните все поля.</p>";
        exit;
    }

    $course_id = $_POST['course_id'];
    $review_text = $_POST['review_text'];
    $rating = $_POST['rating'];

    $stmt = $pdo->prepare("INSERT INTO reviews (user_id, course_id, review_text, rating, created_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->execute([$user_id, $course_id, $review_text, $rating]);

    echo "<p>Отзыв добавлен! <a href='index.php'>Главная</a></p>";
} else {
    header("Location: index.php?page=review");
}
?>
