<?php
require 'db.php';

$sql = "SELECT * FROM courses";
$result = mysqli_query($conn, $sql);

$courses = array();

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $courses[] = $row;
    }
    mysqli_free_result($result);
}

mysqli_close($conn);

header('Content-Type: application/json');
echo json_encode($courses);
?>
