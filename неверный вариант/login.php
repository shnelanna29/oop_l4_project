<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $sql = "SELECT id, password FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $id, $hashed_password);
        if (mysqli_stmt_fetch($stmt)) {
            if (password_verify($password, $hashed_password)) {
                $_SESSION['user_id'] = $id;
                echo "Login successful.";
            } else {
                echo "Incorrect password.";
            }
        } else {
            echo "User not found.";
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Failed to prepare statement.";
    }
}

mysqli_close($conn);
?>
