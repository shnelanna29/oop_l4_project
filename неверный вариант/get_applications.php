<?php
require 'db.php';

$sql = "SELECT * FROM applications";
$result = mysqli_query($conn, $sql);

$applications = array();

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $applications[] = $row;
    }
    mysqli_free_result($result);
}

mysqli_close($conn);

header('Content-Type: application/json');
echo json_encode($applications);
?>
