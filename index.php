<?php
session_start();
require_once 'db.php';

$sql = "SELECT id, cours_name, date_start, date_finish, price, description FROM cours_name";
$result = mysqli_query($connect, $sql);
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Курсы</title>
</head>
<body>
<h1>Сайт курсов</h1>

<?php if (!empty($_SESSION['user_id'])): ?>
    <p>Вы вошли как: <?php echo htmlspecialchars($_SESSION['login']); ?></p>
    <p>
        <a href="request_add.php">Подать заявку</a> |
        <a href="review_add.php">Оставить отзыв</a> |
        <a href="logout.php">Выход</a>
        <?php if (!empty($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin'): ?>
            | <a href="admin_panel.php">Админ‑панель</a>
        <?php endif; ?>
    </p>
<?php else: ?>
    <p><a href="login.php">Войти</a> | <a href="register.php">Регистрация</a></p>
<?php endif; ?>

<h2>Список курсов</h2>
<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Название</th>
        <th>Дата начала</th>
        <th>Дата окончания</th>
        <th>Цена</th>
        <th>Описание</th>
    </tr>
    <?php if ($result && mysqli_num_rows($result) > 0): ?>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo (int)$row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['cours_name']); ?></td>
                <td><?php echo htmlspecialchars($row['date_start']); ?></td>
                <td><?php echo htmlspecialchars($row['date_finish']); ?></td>
                <td><?php echo htmlspecialchars($row['price']); ?></td>
                <td><?php echo htmlspecialchars($row['description']); ?></td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr><td colspan="6">Курсов нет</td></tr>
    <?php endif; ?>
</table>
</body>
</html>
<?php mysqli_close($connect); ?>
