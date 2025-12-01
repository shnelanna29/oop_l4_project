<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $userId     = $_SESSION['user_id'];
    $requestFk  = $_POST['request_fk'] ?? 0;
    $reviewText = $_POST['review_text'] ?? '';

    $stmt = $pdo->prepare("
        INSERT INTO review (user_fk, request_fk, date, review_text)
        VALUES (?, ?, CURRENT_DATE(), ?)
    ");
    $stmt->execute([$userId, $requestFk, $reviewText]);

    header("Location: index.php?page=reviews");
    exit;
}
