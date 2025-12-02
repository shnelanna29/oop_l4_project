<?php
session_start();
require 'db.php';

// Проверка авторизации пользователя
$user_id = $_SESSION['user_id'] ?? null;

$courses = [];
$users = [];
$reviews = [];
$applications = [];

// Получение курсов
$sql = "SELECT * FROM courses";
$result = mysqli_query($conn, $sql);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $courses[] = $row;
    }
    mysqli_free_result($result);
}

// Получение пользователей
$sql = "SELECT * FROM users";
$result = mysqli_query($conn, $sql);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }
    mysqli_free_result($result);
}

// Получение отзывов
$sql = "SELECT * FROM reviews";
$result = mysqli_query($conn, $sql);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $reviews[] = $row;
    }
    mysqli_free_result($result);
}

// Получение заявок
$sql = "SELECT * FROM applications";
$result = mysqli_query($conn, $sql);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $applications[] = $row;
    }
    mysqli_free_result($result);
}

// Закрытие соединения с БД
mysqli_close($conn);

// Здесь вывод HTML + логика отображения данных из массивов выше
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8" />
    <title>Главная страница</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <nav>
        <ul>
            <li><a href="index.php">Главная</a></li>
            <li><a href="login.php">Вход</a></li>
            <li><a href="register.php">Регистрация</a></li>
            <li><a href="apply.php">Подать заявку</a></li>
            <li><a href="review.php">Отзывы</a></li>
        </ul>
    </nav>

    <h1>Добро пожаловать на сайт обучения</h1>

    <?php if ($user_id): ?>
        <p>Вы вошли как пользователь с ID: <?= htmlspecialchars($user_id) ?></p>
    <?php else: ?>
        <p>Вы не авторизованы.</p>
    <?php endif; ?>

    <h2>Курсы</h2>
    <ul>
        <?php foreach ($courses as $course): ?>
            <li><?= htmlspecialchars($course['name']) ?> - <?= htmlspecialchars($course['description']) ?></li>
        <?php endforeach; ?>
    </ul>

    <h2>Пользователи</h2>
    <ul>
        <?php foreach ($users as $user): ?>
            <li><?= htmlspecialchars($user['username']) ?></li>
        <?php endforeach; ?>
    </ul>

    <h2>Отзывы</h2>
    <ul>
        <?php foreach ($reviews as $review): ?>
            <li><?= htmlspecialchars($review['review']) ?></li>
        <?php endforeach; ?>
    </ul>

    <h2>Заявки</h2>
    <ul>
        <?php foreach ($applications as $application): ?>
            <li><?= htmlspecialchars($application['name']) ?> (<?= htmlspecialchars($application['email']) ?>) на курс ID <?= htmlspecialchars($application['course_id']) ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
