<?php
session_start();
require_once 'db.php';

$login    = trim($_POST['login'] ?? '');
$password = $_POST['password'] ?? '';

if ($login === '' || $password === '') {
    $_SESSION['error'] = 'Введите логин и пароль';
    header('Location: login.php');
    exit;
}

$sql = "SELECT u.id, u.password, u.login, ur.role_name
        FROM user u
        JOIN user_role ur ON u.user_type_fk = ur.id
        WHERE u.login = ?";
$stmt = mysqli_prepare($connect, $sql);
mysqli_stmt_bind_param($stmt, "s", $login);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$user || !password_verify($password, $user['password'])) {
    $_SESSION['error'] = 'Неверный логин или пароль';
    header('Location: login.php');
    exit;
}

$_SESSION['user_id']   = (int)$user['id'];
$_SESSION['login']     = $user['login'];
$_SESSION['user_type'] = $user['role_name'];

mysqli_close($connect);

header('Location: index.php');
exit;
