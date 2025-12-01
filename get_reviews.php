<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 2) { die('Доступ запрещён'); }

$stmt = $pdo->query("
    SELECT v.id,
           u.FIO       AS user_fio,
           c.cours_name,
           v.date,
           v.review_text
    FROM review v
    JOIN `user` u   ON v.user_fk   = u.id
    JOIN request r  ON v.request_fk = r.id
    JOIN cours_name c ON r.cours_fk = c.id
");
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h2>Отзывы о курсах</h2>
<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Пользователь</th>
        <th>Курс</th>
        <th>Дата</th>
        <th>Текст отзыва</th>
    </tr>
    <?php foreach ($reviews as $r): ?>
        <tr>
            <td><?= htmlspecialchars($r['id']) ?></td>
            <td><?= htmlspecialchars($r['user_fio']) ?></td>
            <td><?= htmlspecialchars($r['cours_name']) ?></td>
            <td><?= htmlspecialchars($r['date']) ?></td>
            <td><?= nl2br(htmlspecialchars($r['review_text'])) ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<br>
<a href="index.php?page=admin">Назад</a>
