<?php
session_start();
require_once __DIR__ . 'db.php';

$login    = trim($_POST['login'] ?? '');
$password = $_POST['password'] ?? '';
$password_confirm = $_POST['password_confirm'] ?? '';
$fio_user = trim($_POST['fio_user'] ?? '');
$number   = trim($_POST['number'] ?? '');
$email    = trim($_POST['email'] ?? '');

if ($login === '' || $password === '' || $password_confirm === '' ||
    $fio_user === '' || $number === '' || $email === '') {
    $_SESSION['error'] = 'Заполните все поля';
    header('Location: register.php');
    exit;
}

if ($password !== $password_confirm) {
    $_SESSION['error'] = 'Пароли не совпадают';
    header('Location: register.php');
    exit;
}

// проверяем, что логин свободен
$sql = "SELECT id FROM user WHERE login = ?";
$stmt = mysqli_prepare($connect, $sql);
mysqli_stmt_bind_param($stmt, "s", $login);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);
if (mysqli_stmt_num_rows($stmt) > 0) {
    mysqli_stmt_close($stmt);
    $_SESSION['error'] = 'Такой логин уже существует';
    header('Location: register.php');
    exit;
}
mysqli_stmt_close($stmt);

// хешируем пароль
$pass_hash = password_hash($password, PASSWORD_DEFAULT);

// по умолчанию роль обычного пользователя, например user_type_fk = 2
$user_type_fk = 2;

$sql = "INSERT INTO user (login, password, FIO, phone, email, user_type_fk) 
        VALUES (?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($connect, $sql);
mysqli_stmt_bind_param($stmt, "sssssi", $login, $pass_hash, $fio_user, $number, $email, $user_type_fk);

if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    mysqli_close($connect);
    header('Location: login.php');
    exit;
} else {
    $_SESSION['error'] = 'Ошибка регистрации: ' . mysqli_error($connect);
    mysqli_stmt_close($stmt);
    mysqli_close($connect);
    header('Location: register.php');
    exit;
}
