<?php
session_start();
if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
require_once 'db.php';

$user_fk = (int)$_SESSION['user_id'];

$sql = "SELECT r.id, c.cours_name
        FROM request r
        JOIN cours_name c ON r.cours_fk = c.id
        WHERE r.user_fk = ?";
$stmt = mysqli_prepare($connect, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_fk);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Отзыв о курсе</title>
</head>
<body>
<h1>Добавить отзыв</h1>
<?php
if (!empty($_SESSION['error'])) {
    echo '<p style="color:red;">' . htmlspecialchars($_SESSION['error']) . '</p>';
    unset($_SESSION['error']);
}
?>
<form action="review_handler.php" method="post">
    <p>Заявка / курс:
        <select name="request_fk" required>
            <option value="">Выберите заявку</option>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <option value="<?php echo (int)$row['id']; ?>">
                    <?php echo 'Заявка #' . (int)$row['id'] . ' — ' . htmlspecialchars($row['cours_name']); ?>
                </option>
            <?php endwhile; ?>
        </select>
    </p>
    <p>Текст отзыва:<br>
        <textarea name="review_text" cols="50" rows="5" required></textarea>
    </p>
    <p><button type="submit">Отправить отзыв</button></p>
</form>
<p><a href="index.php">На главную</a></p>
</body>
</html>
<?php
mysqli_stmt_close($stmt);
mysqli_close($connect);
?>
