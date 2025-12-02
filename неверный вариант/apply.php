<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $course_id = $_POST['course_id'] ?? '';

    $sql = "INSERT INTO applications (name, email, course_id) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssi", $name, $email, $course_id);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            echo "Application submitted successfully.";
        } else {
            echo "Error submitting application.";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Failed to prepare statement.";
    }
}

mysqli_close($conn);
?>
