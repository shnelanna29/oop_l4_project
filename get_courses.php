<?php
require 'db.php';

$stmt = $pdo->query("SELECT id, name, description, created_at FROM courses");
$courses = $stmt->fetchAll();

echo "<h2>Курсы</h2><table border='1'><tr>
<th>ID</th><th>Название</th><th>Описание</th><th>Дата создания</th>
</tr>";

foreach ($courses as $course) {
    echo "<tr>
    <td>{$course['id']}</td>
    <td>{$course['name']}</td>
    <td>{$course['description']}</td>
    <td>{$course['created_at']}</td>
    </tr>";
}

echo "</table><p><a href='index.php?page=admin'>Назад</a></p>";
?>
