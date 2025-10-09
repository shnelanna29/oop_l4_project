<?php
require 'db.php';

$stmt = $pdo->query("SELECT id, user_id, course_id, desired_start_date, payment_method, status, created_at FROM applications");
$applications = $stmt->fetchAll();

echo "<h2>Заявки</h2><table border='1'><tr>
<th>ID</th><th>Пользователь</th><th>Курс</th><th>Дата старта</th><th>Оплата</th><th>Статус</th><th>Дата заявки</th>
</tr>";

foreach ($applications as $app) {
    echo "<tr>
    <td>{$app['id']}</td>
    <td>{$app['user_id']}</td>
    <td>{$app['course_id']}</td>
    <td>{$app['desired_start_date']}</td>
    <td>{$app['payment_method']}</td>
    <td>{$app['status']}</td>
    <td>{$app['created_at']}</td>
    </tr>";
}

echo "</table><p><a href='index.php?page=admin'>Назад</a></p>";
?>
