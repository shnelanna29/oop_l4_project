<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['login'], $_POST['password'], $_POST['full_name'], $_POST['phone'], $_POST['email'])) {
        $login = $_POST['login'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $full_name = $_POST['full_name'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];

        $stmt = $pdo->prepare("INSERT INTO users (login, password, full_name, phone, email, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
        $stmt->execute([$login, $password, $full_name, $phone, $email]);

        echo "<p>Регистрация успешна! <a href='index.php?page=login'>Войти</a></p>";
    } else {
        die('Ошибка: заполните все поля.');
    }
} else {
    header("Location: index.php?page=register");
}
?>
