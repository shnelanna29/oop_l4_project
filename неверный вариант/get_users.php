<?php
require 'db.php';

$sql = "SELECT * FROM users";
$result = mysqli_query($conn, $sql);

$users = array();

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }
    mysqli_free_result($result);
}

mysqli_close($conn);

header('Content-Type: application/json');
echo json_encode($users);
?>
