<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'] ?? null;
    if (!$user_id) {
        echo "<p>Войдите в систему, чтобы оставить заявку. <a href='index.php?page=login'>Войти</a></p>";
        exit;
    }
    
    if (!isset($_POST['course_id'], $_POST['desired_start_date'], $_POST['payment_method'])) {
        echo "<p>Ошибка: заполните все поля.</p>";
        exit;
    }

    $course_id = $_POST['course_id'];
    $desired_start_date = $_POST['desired_start_date'];
    $payment_method = $_POST['payment_method'];
    $status = 'Новая';

    $stmt = $pdo->prepare("INSERT INTO applications (user_id, course_id, desired_start_date, payment_method, status, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->execute([$user_id, $course_id, $desired_start_date, $payment_method, $status]);

    echo "<p>Заявка отправлена! <a href='index.php'>Главная</a></p>";
} else {
    header("Location: index.php?page=application");
}
?>
