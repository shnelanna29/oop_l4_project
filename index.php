<?php
session_start();
require 'db.php';

$page = $_GET['page'] ?? '';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Курсы</title>
    <link rel="stylesheet" href="style.css">
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
if ($page === 'login') {
    ?>
    <h2>Авторизация</h2>
    <form method="post" action="login.php">
        <label>Логин:
            <input type="text" name="login" required>
        </label>
        <label>Пароль:
            <input type="password" name="password" required>
        </label>
        <input type="submit" value="Войти">
    </form>
    <?php
} elseif ($page === 'register') {
    ?>
    <h2>Регистрация</h2>
    <form method="post" action="register.php">
        <label>Логин:
            <input type="text" name="login" required>
        </label>
        <label>Пароль:
            <input type="password" name="password" required>
        </label>
        <label>ФИО:
            <input type="text" name="fullname" required>
        </label>
        <label>Телефон:
            <input type="text" name="phone">
        </label>
        <label>Email:
            <input type="email" name="email">
        </label>
        <input type="submit" value="Зарегистрироваться">
    </form>
    <?php
} elseif ($page === 'application') {

    // курсы из cours_name
    $courses = $pdo->query("SELECT id, cours_name FROM cours_name")->fetchAll(PDO::FETCH_ASSOC);
    $cashTypes = $pdo->query("SELECT id, cash_type FROM cash_type")->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <h2>Подача заявки</h2>
    <form method="post" action="apply.php">
        <label>Курс:
            <select name="cours_fk" required>
                <?php foreach ($courses as $c): ?>
                    <option value="<?= htmlspecialchars($c['id']) ?>">
                        <?= htmlspecialchars($c['cours_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>
        <label>Желаемая дата старта:
            <input type="date" name="date" required>
        </label>
        <label>Способ оплаты:
            <select name="cash_fk" required>
                <?php foreach ($cashTypes as $ct): ?>
                    <option value="<?= htmlspecialchars($ct['id']) ?>">
                        <?= htmlspecialchars($ct['cash_type']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>
        <input type="submit" value="Отправить заявку">
    </form>
    <?php
} elseif ($page === 'review') {

    if (!isset($_SESSION['user_id'])) {
        echo '<p>Войдите в систему, чтобы оставить отзыв. <a href="?page=login">Войти</a></p>';
    } else {
        $userId = $_SESSION['user_id'];
        $stmt = $pdo->prepare("
            SELECT r.id, c.cours_name
            FROM request r
            JOIN cours_name c ON r.cours_fk = c.id
            WHERE r.user_fk = ?
        ");
        $stmt->execute([$userId]);
        $requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <h2>Добавить отзыв</h2>
        <form method="post" action="review.php">
            <label>Заявка / курс:
                <select name="request_fk" required>
                    <?php foreach ($requests as $r): ?>
                        <option value="<?= htmlspecialchars($r['id']) ?>">
                            <?= htmlspecialchars($r['cours_name']) ?> (заявка №<?= htmlspecialchars($r['id']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label>Текст отзыва:
                <textarea name="review_text" required></textarea>
            </label>
            <input type="submit" value="Отправить отзыв">
        </form>
        <?php
    }
} elseif ($page === 'admin') {
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
