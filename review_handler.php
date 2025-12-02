<?php
session_start();
if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
require_once 'db.php';

$user_fk     = (int)$_SESSION['user_id'];
$request_fk  = (int)($_POST['request_fk'] ?? 0);
$review_text = trim($_POST['review_text'] ?? '');

if ($request_fk <= 0 || $review_text === '') {
    $_SESSION['error'] = 'Заполните все поля';
    header('Location: review_add.php');
    exit;
}

$date = date('Y-m-d');

$sql = "INSERT INTO review (user_fk, request_fk, date, review_text)
        VALUES (?, ?, ?, ?)";
$stmt = mysqli_prepare($connect, $sql);
mysqli_stmt_bind_param($stmt, "iiss", $user_fk, $request_fk, $date, $review_text);

if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    mysqli_close($connect);
    header('Location: index.php');
    exit;
} else {
    $_SESSION['error'] = 'Ошибка при добавлении отзыва: ' . mysqli_error($connect);
    mysqli_stmt_close($stmt);
    mysqli_close($connect);
    header('Location: review_add.php');
    exit;
}
