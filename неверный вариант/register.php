<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ss", $username, $hashed_password);
        if (mysqli_stmt_execute($stmt)) {
            echo "Registration successful.";
        } else {
            echo "Registration failed.";
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Failed to prepare statement.";
    }
}

mysqli_close($conn);
?>
