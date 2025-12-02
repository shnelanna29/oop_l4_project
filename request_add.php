<?php
session_start();
if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
require_once 'db.php';

$courses = mysqli_query($connect, "SELECT id, cours_name FROM cours_name");
$cash_types = mysqli_query($connect, "SELECT id, cash_type FROM cash_type");
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Подача заявки</title>
</head>
<body>
<h1>Подача заявки</h1>
<?php
if (!empty($_SESSION['error'])) {
    echo '<p style="color:red;">' . htmlspecialchars($_SESSION['error']) . '</p>';
    unset($_SESSION['error']);
}
?>
<form action="request_handler.php" method="post">
    <p>Курс:
        <select name="cours_fk" required>
            <option value="">Выберите курс</option>
            <?php while ($row = mysqli_fetch_assoc($courses)): ?>
                <option value="<?php echo (int)$row['id']; ?>">
                    <?php echo htmlspecialchars($row['cours_name']); ?>
                </option>
            <?php endwhile; ?>
        </select>
    </p>
    <p>Тип оплаты:
        <select name="cash_fk" required>
            <option value="">Выберите тип оплаты</option>
            <?php while ($row = mysqli_fetch_assoc($cash_types)): ?>
                <option value="<?php echo (int)$row['id']; ?>">
                    <?php echo htmlspecialchars($row['cash_type']); ?>
                </option>
            <?php endwhile; ?>
        </select>
    </p>
    <p><button type="submit">Отправить заявку</button></p>
</form>
<p><a href="index.php">На главную</a></p>
</body>
</html>
<?php mysqli_close($connect); ?>
