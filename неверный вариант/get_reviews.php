<?php
require 'db.php';

$sql = "SELECT * FROM reviews";
$result = mysqli_query($conn, $sql);

$reviews = array();

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $reviews[] = $row;
    }
    mysqli_free_result($result);
}

mysqli_close($conn);

header('Content-Type: application/json');
echo json_encode($reviews);
?>
