<?php
session_start();
$page = $_GET['page'] ?? '';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8" />
    <title>Учебный сайт</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
<nav>
    <a href="?page=login">Авторизация</a>
    <a href="?page=register">Регистрация</a>
    <a href="?page=application">Подача заявки</a>
    <a href="?page=review">Отзывы</a>
    <a href="?page=admin">Админ панель</a>
</nav>

<?php
require 'db.php';
if ($page == "login") {
?>
<h2>Авторизация</h2>
<form method="post" action="login.php">
    <label>Логин:</label>
    <input type="text" name="login" required />
    <label>Пароль:</label>
    <input type="password" name="password" required />
    <input type="submit" value="Войти" />
</form>
<?php
} elseif ($page == "register") {
    ?>
<h2>Регистрация</h2>
<form method="post" action="register.php">
    <label>Логин:</label>
    <input type="text" name="login" required />
    <label>Пароль:</label>
    <input type="password" name="password" required />
    <label>ФИО:</label>
    <input type="text" name="full_name" required />
    <label>Телефон:</label>
    <input type="text" name="phone" />
    <label>Email:</label>
    <input type="email" name="email" />
    <input type="submit" value="Зарегистрироваться" />
</form>
<?php
} elseif ($page == "application") {
    $courses = $pdo->query("SELECT id, name FROM courses")->fetchAll();
    ?>
<h2>Подача заявки</h2>
<form method="post" action="apply.php">
    <label>Курс:</label>
    <select name="course_id" required>
        <?php foreach($courses as $c) {
            echo "<option value='{$c['id']}'>{$c['name']}</option>";
        } ?>
    </select>
    <label>Желаемая дата старта:</label>
    <input type="date" name="desired_start_date" required />
    <label>Способ оплаты:</label>
    <select name="payment_method" required>
        <option value="наличные">Наличные</option>
        <option value="перевод по номеру телефона">Перевод по номеру телефона</option>
    </select>
    <input type="submit" value="Отправить заявку" />
</form>
<?php
} elseif ($page == "review") {
    $courses = $pdo->query("SELECT id, name FROM courses")->fetchAll();
    ?>
<h2>Добавить отзыв</h2>
<form method="post" action="review.php">
    <label>Курс:</label>
    <select name="course_id" required>
        <?php foreach($courses as $c) {
            echo "<option value='{$c['id']}'>{$c['name']}</option>";
        } ?>
    </select>
    <label>Текст отзыва:</label>
    <textarea name="review_text" required></textarea>
    <label>Оценка:</label>
    <input type="number" name="rating" min="1" max="5" required />
    <input type="submit" value="Оставить отзыв" />
</form>
<?php
} elseif ($page == "admin") {
    ?>
<h2>Админ панель</h2>
<ul>
    <li><a href="get_users.php">Пользователи</a></li>
    <li><a href="get_courses.php">Курсы</a></li>
    <li><a href="get_applications.php">Заявки</a></li>
    <li><a href="get_reviews.php">Отзывы</a></li>
</ul>
<?php
} else {
    ?>
<h2>Добро пожаловать!</h2>
<p>Выберите раздел меню выше.</p>
<?php
}
?>
</body>
</html>
