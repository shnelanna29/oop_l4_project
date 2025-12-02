<?php
session_start();
if (empty($_SESSION['user_id']) || empty($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}
require_once __DIR__ . '/db.php';

$cours_name  = trim($_POST['cours_name'] ?? '');
$date_start  = trim($_POST['date_start'] ?? '');
$date_finish = trim($_POST['date_finish'] ?? '');
$price       = (int)($_POST['price'] ?? 0);
$description = trim($_POST['description'] ?? '');

if ($cours_name === '' || $date_start === '' || $date_finish === '' || $price <= 0) {
    header('Location: admin_panel.php');
    exit;
}

$sql = "INSERT INTO cours_name (cours_name, date_start, date_finish, price, description)
        VALUES (?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($connect, $sql);
mysqli_stmt_bind_param($stmt, "sssds", $cours_name, $date_start, $date_finish, $price, $description);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);
mysqli_close($connect);

header('Location: admin_panel.php');
exit;
