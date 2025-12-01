<?php
session_start();
require_once 'db.php';

$page = $_GET['page'] ?? 'home';
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Курсы</title>
</head>
<body>
<nav>
    <a href="index.php?page=login">Авторизация</a> |
    <a href="index.php?page=register">Регистрация</a> |
    <a href="index.php?page=application">Подача заявки</a> |
    <a href="index.php?page=reviews">Отзывы</a> |
    <a href="index.php?page=admin">Админ панель</a> |
    <a href="index.php">Главная</a>
</nav>
<hr>

<?php if ($page === 'login'): ?>

    <h2>Авторизация</h2>
    <form method="post" action="login.php">
        <label>Логин:<br>
            <input type="text" name="login">
        </label><br><br>
        <label>Пароль:<br>
            <input type="password" name="password">
        </label><br><br>
        <button type="submit">Войти</button>
    </form>

<?php elseif ($page === 'register'): ?>

    <h2>Регистрация</h2>
    <form method="post" action="register.php">
        <label>Логин:<br>
            <input type="text" name="login">
        </label><br><br>
        <label>Пароль:<br>
            <input type="password" name="password">
        </label><br><br>
        <label>ФИО:<br>
            <input type="text" name="fio">
        </label><br><br>
        <label>Телефон:<br>
            <input type="text" name="phone">
        </label><br><br>
        <label>Email:<br>
            <input type="email" name="email">
        </label><br><br>
        <button type="submit">Зарегистрироваться</button>
    </form>

<?php elseif ($page === 'application'): ?>

    <h2>Подача заявки</h2>
    <?php
    if (!isset($_SESSION['user_id'])) {
        echo "Войдите в систему, чтобы оставить заявку.";
        echo '<br><a href="index.php?page=login">Войти</a>';
    } else {
        $courses = $pdo->query("SELECT id, cours_name FROM cours_name")
                       ->fetchAll(PDO::FETCH_ASSOC);
        $cashTypes = $pdo->query("SELECT id, cash_type FROM cash_type")
                         ->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <form method="post" action="apply.php">
        <label>Курс:<br>
            <select name="cours_fk">
                <?php foreach ($courses as $c): ?>
                    <option value="<?= htmlspecialchars($c['id']) ?>">
                        <?= htmlspecialchars($c['cours_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label><br><br>
        <label>Желаемая дата старта:<br>
            <input type="date" name="date">
        </label><br><br>
        <label>Способ оплаты:<br>
            <select name="cash_fk">
                <?php foreach ($cashTypes as $ct): ?>
                    <option value="<?= htmlspecialchars($ct['id']) ?>">
                        <?= htmlspecialchars($ct['cash_type']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label><br><br>
        <button type="submit">Отправить заявку</button>
    </form>
    <?php } ?>

<?php elseif ($page === 'reviews'): ?>

    <h2>Отзывы</h2>
    <?php
    if (!isset($_SESSION['user_id'])) {
        echo "Войдите в систему, чтобы оставить отзыв.";
        echo '<br><a href="index.php?page=login">Войти</a>';
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
    <h3>Добавить отзыв</h3>
    <form method="post" action="review.php">
        <label>Заявка / курс:<br>
            <select name="request_fk">
                <?php foreach ($requests as $r): ?>
                    <option value="<?= htmlspecialchars($r['id']) ?>">
                        <?= htmlspecialchars($r['cours_name']) ?>
                        (заявка №<?= htmlspecialchars($r['id']) ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </label><br><br>
        <label>Текст отзыва:<br>
            <textarea name="review_text" rows="4" cols="50"></textarea>
        </label><br><br>
        <button type="submit">Отправить отзыв</button>
    </form>
    <?php } ?>

<?php elseif ($page === 'admin'): ?>

    <h2>Админ панель</h2>
    <ul>
        <li><a href="get_users.php">Пользователи</a></li>
        <li><a href="get_courses.php">Курсы</a></li>
        <li><a href="get_applications.php">Заявки</a></li>
        <li><a href="get_reviews.php">Отзывы</a></li>
    </ul>

<?php else: ?>

    <h2>Добро пожаловать!</h2>
    <p>Выберите раздел меню выше.</p>

<?php endif; ?>

</body>
</html>
