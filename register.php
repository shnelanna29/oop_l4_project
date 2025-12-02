<?php
session_start();
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
</head>
<body>
<h1>Регистрация</h1>
<?php
if (!empty($_SESSION['error'])) {
    echo '<p style="color:red;">' . htmlspecialchars($_SESSION['error']) . '</p>';
    unset($_SESSION['error']);
}
?>
<form action="register_handler.php" method="post">
    <p>Логин: <input type="text" name="login" required></p>
    <p>Пароль: <input type="password" name="password" required></p>
    <p>Повтор пароля: <input type="password" name="password_confirm" required></p>
    <p>ФИО: <input type="text" name="fio_user" required></p>
    <p>Телефон: <input type="text" name="number" required></p>
    <p>Email: <input type="email" name="email" required></p>
    <p><button type="submit">Зарегистрироваться</button></p>
</form>
<p><a href="index.php">На главную</a></p>
</body>
</html>
