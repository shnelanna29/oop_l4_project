<?php
session_start();
if (empty($_SESSION['user_id']) || empty($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: login.php');
    exit;
}
require_once 'db.php';

$sql_requests = "SELECT r.id, r.date, u.FIO, c.cours_name, s.status_type, ct.cash_type
                 FROM request r
                 JOIN user u ON r.user_fk = u.id
                 JOIN cours_name c ON r.cours_fk = c.id
                 JOIN status s ON r.status_fk = s.id
                 JOIN cash_type ct ON r.cash_fk = ct.id";
$requests = mysqli_query($connect, $sql_requests);

$statuses = mysqli_query($connect, "SELECT id, status_type FROM status");

$courses = mysqli_query($connect, "SELECT id, cours_name, date_start, date_finish, price, description FROM cours_name");
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Админ‑панель</title>
</head>
<body>
<h1>Админ‑панель</h1>
<p><a href="index.php">На главную</a> | <a href="logout.php">Выход</a></p>

<h2>Заявки</h2>
<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Дата</th>
        <th>Пользователь</th>
        <th>Курс</th>
        <th>Статус</th>
        <th>Тип оплаты</th>
        <th>Изменить статус</th>
    </tr>
    <?php if ($requests && mysqli_num_rows($requests) > 0): ?>
        <?php while ($row = mysqli_fetch_assoc($requests)): ?>
            <tr>
                <td><?php echo (int)$row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['date']); ?></td>
                <td><?php echo htmlspecialchars($row['FIO']); ?></td>
                <td><?php echo htmlspecialchars($row['cours_name']); ?></td>
                <td><?php echo htmlspecialchars($row['status_type']); ?></td>
                <td><?php echo htmlspecialchars($row['cash_type']); ?></td>
                <td>
                    <form action="change_status.php" method="post">
                        <input type="hidden" name="request_id" value="<?php echo (int)$row['id']; ?>">
                        <select name="status_fk">
                            <?php
                            mysqli_data_seek($statuses, 0);
                            while ($st = mysqli_fetch_assoc($statuses)): ?>
                                <option value="<?php echo (int)$st['id']; ?>">
                                    <?php echo htmlspecialchars($st['status_type']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                        <button type="submit">OK</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr><td colspan="7">Заявок нет</td></tr>
    <?php endif; ?>
</table>

<h2>Курсы</h2>
<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Название</th>
        <th>Дата начала</th>
        <th>Дата окончания</th>
        <th>Цена</th>
        <th>Описание</th>
    </tr>
    <?php if ($courses && mysqli_num_rows($courses) > 0): ?>
        <?php while ($c = mysqli_fetch_assoc($courses)): ?>
            <tr>
                <td><?php echo (int)$c['id']; ?></td>
                <td><?php echo htmlspecialchars($c['cours_name']); ?></td>
                <td><?php echo htmlspecialchars($c['date_start']); ?></td>
                <td><?php echo htmlspecialchars($c['date_finish']); ?></td>
                <td><?php echo htmlspecialchars($c['price']); ?></td>
                <td><?php echo htmlspecialchars($c['description']); ?></td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr><td colspan="6">Курсов нет</td></tr>
    <?php endif; ?>
</table>

<h3>Добавить курс</h3>
<form action="course_add.php" method="post">
    <p>Название: <input type="text" name="cours_name" required></p>
    <p>Дата начала: <input type="date" name="date_start" required></p>
    <p>Дата окончания: <input type="date" name="date_finish" required></p>
    <p>Цена: <input type="number" name="price" required></p>
    <p>Описание:<br>
        <textarea name="description" cols="50" rows="3"></textarea>
    </p>
    <p><button type="submit">Добавить</button></p>
</form>
</body>
</html>
<?php mysqli_close($connect); ?>
