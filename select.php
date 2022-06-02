<?php
include "conn.php";

$stmt = $con->prepare("SELECT name, content FROM info");
$stmt->execute();

while ($row = $stmt->fetch()) {
    echo $row['name'] . "<br>";
    echo $row['content'];
    echo "<br>";
}
