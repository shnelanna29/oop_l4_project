<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'] ?? '';
    $review = $_POST['review'] ?? '';

    $sql = "INSERT INTO reviews (user_id, review) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "is", $user_id, $review);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            echo "Review submitted successfully.";
        } else {
            echo "Error submitting review.";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Failed to prepare statement.";
    }
}

mysqli_close($conn);
?>
