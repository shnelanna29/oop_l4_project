<?php
session_start();
if (empty($_SESSION['user_id']) || empty($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}
require_once __DIR__ . '/db.php';

$request_id = (int)($_POST['request_id'] ?? 0);
$status_fk  = (int)($_POST['status_fk'] ?? 0);

if ($request_id <= 0 || $status_fk <= 0) {
    header('Location: admin_panel.php');
    exit;
}

$sql = "UPDATE request SET status_fk = ? WHERE id = ?";
$stmt = mysqli_prepare($connect, $sql);
mysqli_stmt_bind_param($stmt, "ii", $status_fk, $request_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);
mysqli_close($connect);

header('Location: admin_panel.php');
exit;
