<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'lab3_oop';

$connect = mysqli_connect($host, $user, $pass, $db);

if (!$connect) {
    die('Ошибка подключения к БД: ' . mysqli_connect_error());
}

mysqli_set_charset($connect, 'utf8mb4');
?>
