<?php
require 'db.php';

$stmt = $pdo->query("SELECT id, user_id, course_id, review_text, rating, created_at FROM reviews");
$reviews = $stmt->fetchAll();

echo "<h2>Отзывы</h2><table border='1'><tr>
<th>ID</th><th>Пользователь</th><th>Курс</th><th>Отзыв</th><th>Оценка</th><th>Дата</th>
</tr>";

foreach ($reviews as $review) {
    echo "<tr>
    <td>{$review['id']}</td>
    <td>{$review['user_id']}</td>
    <td>{$review['course_id']}</td>
    <td>{$review['review_text']}</td>
    <td>{$review['rating']}</td>
    <td>{$review['created_at']}</td>
    </tr>";
}

echo "</table><p><a href='index.php?page=admin'>Назад</a></p>";
?>
