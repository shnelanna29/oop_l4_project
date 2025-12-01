<?php
session_start();
require_once 'db.php';



$stmt = $pdo->query("
    SELECT id, cours_name, date_start, date_finish, price, description
    FROM cours_name
");
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
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
    <?php foreach ($courses as $c): ?>
        <tr>
            <td><?= htmlspecialchars($c['id']) ?></td>
            <td><?= htmlspecialchars($c['cours_name']) ?></td>
            <td><?= htmlspecialchars($c['date_start']) ?></td>
            <td><?= htmlspecialchars($c['date_finish']) ?></td>
            <td><?= htmlspecialchars($c['price']) ?></td>
            <td><?= htmlspecialchars($c['description']) ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<br>
<a href="index.php?page=admin">Назад</a>
