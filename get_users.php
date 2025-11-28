<?php
require 'db.php';

$stmt = $pdo->query("
    SELECT u.id, u.login, u.FIO, u.phone, u.email, r.role_name
    FROM `user` u
    JOIN user_role r ON u.user_type_fk = r.id
");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h2>Пользователи</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Логин</th>
        <th>ФИО</th>
        <th>Телефон</th>
        <th>Email</th>
        <th>Роль</th>
    </tr>
    <?php foreach ($users as $u): ?>
        <tr>
            <td><?= htmlspecialchars($u['id']) ?></td>
            <td><?= htmlspecialchars($u['login']) ?></td>
            <td><?= htmlspecialchars($u['FIO']) ?></td>
            <td><?= htmlspecialchars($u['phone']) ?></td>
            <td><?= htmlspecialchars($u['email']) ?></td>
            <td><?= htmlspecialchars($u['role_name']) ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<p><a href="index.php?page=admin">Назад</a></p>
