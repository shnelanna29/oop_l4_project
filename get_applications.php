<?php
require 'db.php';

$stmt = $pdo->query("
    SELECT r.id,
           r.date,
           u.FIO AS user_fio,
           c.cours_name,
           s.status_type,
           ct.cash_type
    FROM request r
    JOIN `user` u      ON r.user_fk  = u.id
    JOIN cours_name c  ON r.cours_fk = c.id
    JOIN status s      ON r.status_fk = s.id
    JOIN cash_type ct  ON r.cash_fk  = ct.id
");
$applications = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h2>Заявки</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Дата</th>
        <th>Пользователь</th>
        <th>Курс</th>
        <th>Статус</th>
        <th>Оплата</th>
    </tr>
    <?php foreach ($applications as $a): ?>
        <tr>
            <td><?= htmlspecialchars($a['id']) ?></td>
            <td><?= htmlspecialchars($a['date']) ?></td>
            <td><?= htmlspecialchars($a['user_fio']) ?></td>
            <td><?= htmlspecialchars($a['cours_name']) ?></td>
            <td><?= htmlspecialchars($a['status_type']) ?></td>
            <td><?= htmlspecialchars($a['cash_type']) ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<p><a href="index.php?page=admin">Назад</a></p>
