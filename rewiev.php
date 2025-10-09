<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $course_id = $_POST['course_id'];
    $review_text = $_POST['review_text'];
    $rating = $_POST['rating'];

    $stmt = $pdo->prepare("INSERT INTO oop_l4_reviews (user_id, course_id, review_text, rating, created_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->execute([$user_id, $course_id, $review_text, $rating]);

    echo "Отзыв добавлен! <a href='index.php'>На главную</a>";
} else {
    header("Location: index.php?page=review");
}
?>
